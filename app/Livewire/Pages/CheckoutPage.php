<?php

namespace App\Livewire\Pages;

use App\Enums\PaymentMethod;
use App\Enums\ShippingMethod;
use App\Facades\Cart;
use App\Jobs\SendOrderEmail;
use App\Models\City;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CheckoutPage extends Component
{
    public string $name;

    public string $email;

    public ?string $phone = null;

    public ?string $city = null;

    public string $address;

    public string $notes;

    public string $paymentMethod = 'cash';

    public string $shippingMethod = 'courier';

    public array $cities = [];

    public function mount(): void
    {
        // Get the cart items
        $this->validateCart();

        if (auth()->check()) {
            $this->name = auth()->user()->name;
            $this->email = auth()->user()->email;
            $this->phone = auth()->user()->phone;
            $this->city = auth()->user()->city_id;
        }

        // Get the cities
        $this->cities = City::status()->get()->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
            ];
        })->toArray();
    }

    /**
     * Get the cart items
     */
    #[Computed]
    public function cartItems(): Collection
    {
        return Cart::getContent();
    }

    /**
     * Get the cart total
     */
    #[Computed]
    public function cartTotal(): float
    {
        return Cart::total();
    }

    /**
     * Get the shipping methods
     */
    public function getShippingMethods(): array
    {
        return ShippingMethod::cases();
    }

    /**
     * Get the payment methods
     */
    public function getPaymentMethods(): array
    {
        return PaymentMethod::cases();
    }

    /**
     * Create a new order
     */
    public function createOrder(): void
    {
        // Validate form fields
        $validated = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|min:4|max:64',
            'phone' => 'required|string|min:8|max:12',
            'city' => 'required|exists:cities,id',
            'address' => 'required|string|min:4|max:255',
            'notes' => 'nullable|string|max:255',
            'paymentMethod' => ['required', new Enum(PaymentMethod::class)],
            'shippingMethod' => ['required', new Enum(ShippingMethod::class)],
        ]);

        // Validate cart items before creating the order
        $this->validateCart();

        if (Cart::getErrors()->isNotEmpty()) {
            $this->dispatch('alert', 'Unable to place the order. Please resolve the errors and try again.', 'error');

            return;
        }

        // Create the order transaction
        $order = null;
        DB::transaction(function () use ($validated, &$order) {
            $order = $this->createOrderTransaction($validated, Cart::getContent());
        });

        if ($order === null) {
            $this->dispatch('alert', 'Failed to create the order. Please try again.', 'error');

            logger()->error('Failed to create the order', [
                'validated' => $validated,
                'cart' => Cart::getContent(),
            ]);
        }

        try {
            $this->sendOrderEmails($order);
        } catch (\Throwable $e) {
            // Log the error for debugging
            logger()->error('Failed to send order emails: '.$e->getMessage(), [
                'order_id' => $order->id ?? null,
            ]);

            // Optionally, notify the user about the issue
            $this->dispatch('alert', 'Order created successfully, but we encountered an issue with email notifications.', 'warning');
        }

        $this->dispatch('alert', 'Order created successfully', 'success');
        // Redirect to success page
        $this->redirect(route('order-success-page', $order->number));
    }

    /**
     * Create the order transaction
     */
    private function createOrderTransaction($validated, $products): Order
    {
        // Generate a unique order number
        do {
            $number = Str::ulid();
        } while (Order::where('number', $number)->exists());

        // Insert order data
        $data = [
            'number' => $number,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'city_id' => $validated['city'],
            'shipping_address' => $validated['address'],
            'notes' => $validated['notes'],
            'payment_method' => $validated['paymentMethod'],
            'shipping_method' => $validated['shippingMethod'],
            'total' => Cart::total(),
        ];

        // Insert user id if authenticated
        if (auth()->check()) {
            $data['user_id'] = auth()->user()->id;
        }

        // Create a new order record
        $order = Order::create($data);

        // Create order items
        $products->each(function ($item) use ($order) {
            $product = Product::find($item['id']);

            $order->items()->create([
                'product_id' => $product->id,
                'supplier_id' => $product->user->id,
                'price' => $product->price,
                'total' => $item['quantity'] * $product->price,
                'quantity' => $item['quantity'],
            ]);

            // Decrement product quantity
            $product->decrement('quantity', $item['quantity']);
        });

        // Clear the cart
        Cart::clear();

        // Reset form fields
        $this->reset(['name', 'email', 'phone', 'city', 'address', 'notes', 'paymentMethod', 'shippingMethod']);

        return $order;
    }

    private function sendOrderEmails(Order $order): void
    {
        // Notify the customer
        SendOrderEmail::dispatch($order, $order->email);
    }

    /**
     * Remove a cart item
     */
    public function removeCartItem(Product $productId): void
    {
        Cart::remove($productId);

        $this->dispatch('alert', 'Product removed from cart', 'success');
    }

    /**
     * Validate the cart items
     */
    private function validateCart(): void
    {
        $products = Cart::getContent();
        $productIds = $products->pluck('id')->toArray();
        $existingProducts = Product::whereIn('id', $productIds)->get()->keyBy('id');
        foreach ($products as $item) {
            Cart::validateProduct($existingProducts[$item['id']] ?? null, $item['quantity']);
        }
    }

    public function decreaseCartItem($cartItemId): void
    {
        Cart::decrease($cartItemId);

        $this->validateCart();
    }

    public function increaseCartItem($cartItemId): void
    {
        Cart::increase($cartItemId);

        $this->validateCart();
    }

    #[Computed]
    public function getCartErrors(): Collection
    {
        return Cart::getErrors();
    }

    #[Computed]
    public function getCartWarnings(): Collection
    {
        return Cart::getWarnings();
    }

    public function render()
    {
        return view('livewire.pages.checkout-page');
    }
}

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
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CheckoutPage extends Component
{
    public string $name;
    public string $email;
    public string $phone;
    public string $city;
    public string $address;
    public string $notes;
    public string $paymentMethod = 'cash';
    public string $shippingMethod = 'courier';

    public array $cities = [];

    public function mount(): void
    {
        // Get the cart items
        $this->validateCart();

        // Get the cities
        $this->cities = City::all()->map(function ($city) {
            return [
                'id' => $city->id,
                'name' => $city->name,
            ];
        })->toArray();
    }

    /**
     * Get the cart items
     *
     * @return Collection
     */
    #[Computed]
    public function cartItems(): Collection
    {
        return Cart::getContent();
    }

    /**
     * Get the cart total
     *
     * @return float
     */
    #[Computed]
    public function cartTotal(): float
    {
        return Cart::total();
    }

    /**
     * Get the shipping methods
     *
     * @return array
     */
    public function getShippingMethods(): array
    {
        return ShippingMethod::cases();
    }

    /**
     * Get the payment methods
     *
     * @return array
     */
    public function getPaymentMethods(): array
    {
        return PaymentMethod::cases();
    }

    /**
     * Create a new order
     *
     * @return void
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
            'paymentMethod' => ['required', Rule::in(PaymentMethod::cases())],
            'shippingMethod' => ['required', Rule::in(ShippingMethod::cases())],
        ]);

        try {
            // Get the cart items
            $products = Cart::getContent();

            // Validate cart items before creating the order
            $this->validateCart();

            // Insert order data
            $data = [
                'number' => Str::ulid(),
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

            // Supplier email notification with queue
            $suppliers = $order->items
                ->pluck('supplier.email', 'supplier.id')
                ->unique();

            foreach ($suppliers as $email) {
                SendOrderEmail::dispatch($order, $email);
            }

            // User email notification with queue
            SendOrderEmail::dispatch($order, $order->email);

            $this->redirect(route('order.success', $order->number));

        } catch (\Exception $e) {
            report($e);
            $this->addError('order', 'An error occurred while creating the order.');
        }
    }

    /**
     * Remove a cart item
     *
     * @param Product $productId
     * @return void
     */
    public function removeCartItem(Product $productId): void
    {
        Cart::remove($productId);
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

    #[Computed]
    public function getCartErrors(): Collection
    {
        return Cart::getErrors();
    }

    public function render()
    {
        return view('livewire.pages.checkout-page');
    }
}

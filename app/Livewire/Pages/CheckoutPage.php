<?php

namespace App\Livewire\Pages;

use App\Facades\Cart;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class CheckoutPage extends Component
{
    public string $name;
    public string $email;
    public string $phone;
    public string $address;
    public string $notes;
    public string $paymentMethod = 'cash';
    public string $shippingMethod;

    /**
     * Get the cart items
     *
     * @return Collection
     */
    #[Computed]
    public function cartItems(): Collection
    {
        return Cart::content();
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

    public function createOrder(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|min:4|max:64',
            'phone' => 'required|string|min:8|max:12',
            'address' => 'required|string|min:4|max:255',
            'notes' => 'nullable|string|max:255',
            'paymentMethod' => 'required|string',
            'shippingMethod' => 'required|string',
        ]);

        $order = new Order();
        $order->name = $this->name;
        $order->email = $this->email;
        $order->phone = $this->phone;
        $order->shipping_address = $this->address;
        $order->notes = $this->notes;
        $order->payment_method = $this->paymentMethod;
        $order->total = Cart::total();
        $order->save();

        Cart::content()->each(function ($item) use ($order) {
            $product = Product::find($item->id);

            $order->items()->create([
                'product_id' => $product->id,
                'supplier_id' => $product->user()->id,
                'price' => $product->price,
                'total' => $item->total * $product->price,
                'quantity' => $item->quantity,
            ]);
        });

        // Supplier email notification with queue
        // User email notification with queue
    }

    public function render()
    {
        return view('livewire.pages.checkout-page');
    }
}

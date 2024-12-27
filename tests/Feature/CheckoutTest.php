<?php

use App\Enums\ProductStatus;
use App\Facades\Cart;
use App\Models\Product;
use Livewire\Livewire;

it('renders the checkout page', function () {
    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->assertStatus(200);
});

it('can create order', function () {
    $city = \App\Models\City::factory()->create();
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 50,
        'quantity' => 20,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);

    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->set('name', 'John Doe')
        ->set('email', 'test@example.com')
        ->set('phone', '123456789')
        ->set('city', $city->id)
        ->set('address', '123 Main St')
        ->set('notes', 'Some notes')
        ->set('paymentMethod', \App\Enums\PaymentMethod::Cash->value)
        ->set('shippingMethod', \App\Enums\ShippingMethod::Courier->value)
        ->call('createOrder');

    $this->assertDatabaseHas('orders', [
        'name' => 'John Doe',
        'email' => 'test@example.com',
        'phone' => '123456789',
        'city_id' => $city->id,
        'shipping_address' => '123 Main St',
        'notes' => 'Some notes',
        'payment_method' => \App\Enums\PaymentMethod::Cash->value,
        'shipping_method' => \App\Enums\ShippingMethod::Courier->value,
    ]);
});

<?php

use App\Facades\Cart;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function () {
    // Создаем фиктивные данные
    $this->country = Country::factory()->create();
    $this->region = Region::factory()->create();
    $this->user = User::factory()->create();
    $this->city = City::factory()->create();
    $this->category = Category::factory()->create();
    $this->product = Product::factory()->create(['quantity' => 10]);
    $this->cartItem = [
        'id' => $this->product->id,
        'name' => $this->product->name,
        'price' => $this->product->price,
        'quantity' => 2,
    ];

    // Добавляем товар в корзину
    Cart::add($this->product);
});

it('renders the checkout page', function () {
    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->assertStatus(200);
});

it('validates the checkout form', function () {
    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->set('name', '') // Пустое имя
        ->set('email', 'invalid-email') // Неверный email
        ->set('phone', '123') // Слишком короткий номер телефона
        ->set('city', null) // Пустой город
        ->set('address', '')
        ->set('notes', str_repeat('A', 300)) // Слишком длинное примечание
        ->set('paymentMethod', 'invalid') // Некорректный метод оплаты
        ->set('shippingMethod', 'invalid') // Некорректный метод доставки
        ->call('createOrder')
        ->assertHasErrors([
            'name',
            'email',
            'phone',
            'city',
            'address',
            'notes',
            'paymentMethod',
            'shippingMethod',
        ]);
});

it('creates an order successfully', function () {
    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->set('phone', '1234567890')
        ->set('city', $this->city->id)
        ->set('address', '123 Test Street')
        ->set('notes', 'Please deliver quickly')
        ->set('paymentMethod', 'cash')
        ->set('shippingMethod', 'courier')
        ->call('createOrder');

    //    $order = \App\Models\Order::latest('id')->first();
    //
    //    Livewire::test(\App\Livewire\Pages\OrderSuccess::class)
    //        ->assertRedirect(route('order-success-page', $order->number));

    // Проверяем, что заказ был создан
    $this->assertDatabaseHas('orders', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'city_id' => $this->city->id,
        'shipping_address' => '123 Test Street',
        'total' => $this->product->price * $this->cartItem['quantity'],
    ]);
});

it('removes a product from the cart', function () {
    Livewire::test(\App\Livewire\Pages\CheckoutPage::class)
        ->call('removeCartItem', $this->product->id);

    // Проверяем, что корзина пуста
    expect(Cart::getContent()->isEmpty())->toBeTrue();
});

<?php

/** @test */

use App\Enums\ProductStatus;
use App\Facades\Cart;
use App\Models\Product;

it('can add a product to cart', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 50,
        'quantity' => 20,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);
    Cart::add($product, 3);

    $items = Cart::getContent();

    expect($items)->toHaveCount(1);
    expect($items->first()['quantity'])->toBe(5);
    expect(Cart::total())->toBe(250.0);
});

it('can increase and decrease product quantity', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 100,
        'quantity' => 5,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);
    Cart::increase($product->id); // Returns 3
    Cart::decrease($product->id); // Returns 2

    $items = Cart::getContent();
    expect($items->first()['quantity'])->toBe(2);
});

it('removes a product from cart', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 100,
        'quantity' => 10,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);
    Cart::remove($product);

    expect(Cart::getContent())->toBeEmpty();
});

it('clears the cart', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 100,
        'quantity' => 10,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);
    Cart::remove($product);

    expect(Cart::getContent())->toBeEmpty();
});


it('adds error if product not published', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Draft, // Not published
        'price' => 100,
        'quantity' => 10,
        'minimum' => 1,
    ]);

    Cart::add($product, 2);
    $errors = Cart::getErrors();

    expect($errors)->not->toBeEmpty()
        ->and($errors->first()['errors']->first('status'))
        ->toBe('This product is not available for purchase.');
});

it('adds error if requested quantity less than minimum', function () {
    $product = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 100,
        'quantity' => 10,
        'minimum' => 5,
    ]);

    Cart::add($product, 2);
    $errors = Cart::getErrors();

    expect($errors)->not->toBeEmpty()
        ->and($errors->first()['errors']->first('requested_quantity'))
        ->toContain('The minimum quantity for this product is 5.');
});

it('calculates total correctly', function () {
    $product1 = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 100,
        'quantity' => 10,
        'minimum' => 1,
    ]);

    $product2 = Product::factory()->create([
        'status' => ProductStatus::Published,
        'price' => 50,
        'quantity' => 10,
        'minimum' => 1,
    ]);

    Cart::add($product1, 2); // 200
    Cart::add($product2, 3); // 150

    expect(Cart::total())->toBe(350.0);
});

<?php

use App\Enums\ProductStatus;
use App\Models\City;
use App\Models\Country;
use App\Models\Region;
use App\Models\User;
use Illuminate\Http\UploadedFile;

it('displays the CreateProduct page for the supplier', function () {
    Country::factory()->create();
    Region::factory()->create();
    City::factory()->create();

    $this->actingAs(User::factory()->create());

    Livewire::test(\App\Livewire\Supplier\Products\CreatePage::class)
        ->assertStatus(200);
});

it('successfully creates a product', function () {
    $category = \App\Models\Category::factory()->create(['status' => true]);
    Country::factory()->create();
    Region::factory()->create();
    City::factory()->create();

    $this->actingAs(User::factory()->create());

    Livewire::test(\App\Livewire\Supplier\Products\CreatePage::class)
        ->set('category', $category->id)
        ->set('name', 'Product name')
        ->set('description', 'Product description')
        ->set('photo', UploadedFile::fake()->image('photo.jpg'))
        ->set('price', 100)
        ->set('minimum', 1)
        ->set('quantity', 10)
        ->set('weight', 1)
        ->set('status', ProductStatus::Draft->value)
        ->call('createProduct');

    $this->assertDatabaseHas('products', [
        'name' => 'Product name',
        'description' => 'Product description',
        'price' => 100,
        'minimum' => 1,
        'quantity' => 10,
        'weight' => 1,
        'status' => ProductStatus::Draft->value,
    ]);
});

it('shows validation errors when creating a product with invalid data', function () {
    Country::factory()->create();
    Region::factory()->create();
    City::factory()->create();

    $this->actingAs(User::factory()->create());

    Livewire::test(\App\Livewire\Supplier\Products\CreatePage::class)
        ->set('category', null)
        ->set('photo', '')
        ->set('name', '')
        ->set('description', '')
        ->set('price', -10)
        ->set('minimum', 0)
        ->set('quantity', 0)
        ->set('weight', -1)
        ->set('status', 5)
        ->call('createProduct')
        ->assertHasErrors([
            'category' => 'required',
            'photo' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'min',
            'minimum' => 'min',
            'quantity' => 'min',
            'weight' => 'min',
            'status' => 'in',
        ]);
});

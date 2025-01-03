<?php

use App\Livewire\Auth;
use App\Livewire\Pages;
use App\Livewire\Supplier;
use Illuminate\Support\Facades\Route;

Route::get('/', Pages\HomePage::class)->name('home-page');
Route::get('/category/{id}', Pages\CategoryPage::class)->name('category-page');
Route::get('/product/{id}', Pages\ProductPage::class)->name('product-page');
Route::get('/checkout', Pages\CheckoutPage::class)->name('checkout-page');
Route::get('/order-success/{number}', Pages\OrderSuccess::class)->name('order-success-page');

Route::middleware('guest')->group(function () {
    Route::get('/login', Auth\LoginPage::class)->name('login-page');
    Route::get('/register', Auth\RegisterPage::class)->name('register-page');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', static function () {
        auth()->logout();

        return redirect()->route('home-page');
    })->name('logout');

    Route::get('/profile', Auth\ProfilePage::class)->name('profile-page');

    Route::get('/supplier/products', Supplier\Products\ListPage::class)->name('supplier-products-page');
    Route::get('/supplier/products/create', Supplier\Products\CreatePage::class)->name('supplier-products-create-page');
    Route::get('/supplier/products/{product}', Supplier\Products\EditPage::class)->name('supplier-products-edit-page');
    Route::get('/supplier/orders', Supplier\Orders\ListPage::class)->name('supplier-orders-page');
    Route::get('/supplier/orders/{order}', Supplier\Orders\ViewPage::class)->name('supplier-orders-view-page');
    Route::get('/supplier/reviews', Supplier\Reviews\ListPage::class)->name('supplier-reviews-page');

    Route::get('/customer/orders', App\Livewire\Customer\Orders\ListPage::class)->name('customer-orders-page');
    Route::get('/customer/orders/{order}', App\Livewire\Customer\Orders\ViewPage::class)->name('customer-orders-view-page');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages;
use App\Livewire\Auth;

Route::get('/', Pages\HomePage::class)->name('home-page');
Route::get('/category/{slug}', Pages\CategoryPage::class)->name('category-page');
Route::get('/product/{id}', Pages\ProductPage::class)->name('product-page');
Route::get('/checkout', Pages\CheckoutPage::class)->name('checkout-page');

Route::middleware('guest')->group(function () {
    Route::get('/login', Auth\LoginPage::class)->name('login-page');
    Route::get('/register', Auth\RegisterPage::class)->name('register-page');
});

Route::middleware('auth')->group(function () {

});

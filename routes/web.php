<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages;

Route::get('/', Pages\HomePage::class)->name('home-page');
Route::get('/category/{slug}', Pages\CategoryPage::class)->name('category-page');
Route::get('/product/{id}', Pages\ProductPage::class)->name('product-page');

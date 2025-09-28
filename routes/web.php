<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/products', 'products.index');
Route::view('/products/{id}', 'products.show');
Route::view('/cart', 'cart.index');
Route::view('/checkout', 'checkout.index');
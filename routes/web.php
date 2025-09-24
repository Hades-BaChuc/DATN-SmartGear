<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'home');
Route::view('/books', 'books.index');
Route::view('/books/{id}', 'books.show');
Route::view('/cart', 'cart.index');
Route::view('/checkout', 'checkout.index');
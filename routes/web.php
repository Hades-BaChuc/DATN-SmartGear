<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\ProductController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\LaptopController;
use App\Http\Controllers\Web\AuthController;

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// Products
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])
    ->whereNumber('id') // tránh đụng các path khác
    ->name('products.show');
Route::redirect('/product', '/products'); // alias cũ nếu có

// Cart (session-based)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->whereNumber('id')->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
});

Route::prefix('laptop')->name('laptop.')->group(function () {
    Route::get('/', [LaptopController::class, 'index'])->name('index');            // /laptop
    Route::get('/{brand:slug}', [LaptopController::class, 'brand'])->name('brand'); // /laptop/asus
});

Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

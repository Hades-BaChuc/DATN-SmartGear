<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\CartController;

Route::prefix('v1')->group(function () {
    // Auth (public)
    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Public data
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show'])->whereNumber('id');

    // Protected (Bearer token)
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/auth/logout', [AuthController::class, 'logout']);

        Route::get('/cart', [CartController::class, 'index']);
        Route::post('/cart/add', [CartController::class, 'add']);
        Route::post('/cart/update', [CartController::class, 'update']);
        Route::post('/cart/remove', [CartController::class, 'remove']);
        Route::post('/cart/clear', [CartController::class, 'clear']);
    });
});

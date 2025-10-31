<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\{
HomeController,
CategoryController,
ProductController,
CartController,
CheckoutController,
OrderController,
ProfileController
};

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Sản phẩm (danh sách + chi tiết)
Route::prefix('products')->name('products.')->group(function () {
Route::get('/', [ProductController::class, 'index'])->name('index');
Route::get('/{slug}', [ProductController::class, 'show'])->name('show');
});

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::post('/cart/buy-now', [CartController::class, 'buyNow'])->name('cart.buyNow');
Route::patch('/cart/{item}', [CartController::class, 'update'])->name('cart.update');
Route::patch('/cart/update/{id}', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');
Route::delete('/cart/{item}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

// Khu vực cần đăng nhập
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{code}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
});

// NẠP ROUTE AUTH CỦA BREEZE (đăng nhập/đăng ký/đổi mật khẩu, v.v.)
require __DIR__.'/auth.php';

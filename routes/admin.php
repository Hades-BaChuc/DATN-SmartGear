<?php
use App\Http\Controllers\Admin\{DashboardController,ProductAdminController,CategoryAdminController,BrandAdminController,OrderAdminController};


Route::middleware(['auth','can:access-admin'])->prefix('admin')->name('admin.')->group(function(){
Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('products', ProductAdminController::class);
Route::resource('categories', CategoryAdminController::class);
Route::resource('brands', BrandAdminController::class);
Route::resource('orders', OrderAdminController::class)->only(['index','show','update']);

});
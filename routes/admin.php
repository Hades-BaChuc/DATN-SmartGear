<?php
use App\Http\Controllers\Admin\{DashboardController,BookAdminController,CategoryAdminController,AuthorAdminController,OrderAdminController};


Route::middleware(['auth','can:access-admin'])->prefix('admin')->name('admin.')->group(function(){
Route::get('/', [DashboardController::class,'index'])->name('dashboard');
Route::resource('books', BookAdminController::class);
Route::resource('categories', CategoryAdminController::class);
Route::resource('authors', AuthorAdminController::class);
Route::resource('orders', OrderAdminController::class)->only(['index','show','update']);

});
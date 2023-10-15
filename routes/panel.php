<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panel\{UserController, CategoryController, ProductController, DashboardController};

// Admin Panel
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

//Users
Route::controller(UserController::class)->name('admin.')->group(function () {
    Route::put('/users/{user}/restore', 'restore')->withTrashed()->name('users.restore');
    Route::post('/users/{user}/force-delete', 'forceDelete')->withTrashed()->name('users.force-delete');
    Route::get('/users/export', 'export')->name('users.export');
});


//Categories
Route::controller(CategoryController::class)->name('admin.')->group(function () {
    Route::put('/categories/{category}/restore', 'restore')->withTrashed()->name('categories.restore');
    Route::post('/categories/{category}/force-delete', 'forceDelete')->withTrashed()->name('categories.force-delete');
    Route::get('/categories/export', 'export')->name('categories.export');
});

//Products
Route::controller(ProductController::class)->name('admin.')->group(function () {
    Route::put('/products/{product}/restore', 'restore')->withTrashed()->name('products.restore');
    Route::post('/products/{product}/force-delete', 'forceDelete')->withTrashed()->name('products.force-delete');
    Route::get('/products/export', 'export')->name('products.export');
});

Route::name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
});




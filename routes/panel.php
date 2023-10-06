<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\ProductController;
use App\Http\Controllers\Panel\CategoryController;
use App\Http\Controllers\Panel\DashboardController;


// Admin Panel
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

//Users
Route::controller(UserController::class)->group(function (){
    Route::get('/users', 'index')->name('admin.users.index');
    Route::get('/users/create', 'create')->name('admin.users.create');
    Route::post('/users', 'store')->name('admin.users.store');
    Route::get('/users/{id}/edit', 'edit')->name('admin.users.edit');
    Route::patch('/users/{id}', 'update')->name('admin.users.update');
    Route::get('users/trash', 'trash')->name('admin.users.trash');
    Route::get('/users/{id}/restore', 'restore')->name('admin.users.restore');
    Route::get('/users/{id}/delete-force', 'deleteForever')->name('admin.users.delete-force');
    Route::get('/users/search', 'search')->name('admin.users.search');
    Route::get('/users/export', 'export')->name('admin.users.export');
    Route::delete('/users/{id}', 'delete')->name('admin.users.delete');
});

//Categories
Route::controller(CategoryController::class)->group(function (){
    Route::get('/categories', 'index')->name('admin.categories.index');
    Route::get('/categories/create', 'create')->name('admin.categories.create');
    Route::post('/categories', 'store')->name('admin.categories.store');
    Route::get('/categories/{id}/edit', 'edit')->name('admin.categories.edit');
    Route::patch('/categories/{id}', 'update')->name('admin.categories.update');
    Route::get('categories/trash', 'trash')->name('admin.categories.trash');
    Route::get('/categories/{id}/restore', 'restore')->name('admin.categories.restore');
    Route::get('/categories/{id}/delete-force', 'deleteForever')->name('admin.categories.delete-force');
    Route::get('/categories/search', 'search')->name('admin.categories.search');
    Route::get('/categories/export', 'export')->name('admin.categories.export');
    Route::delete('/categories/{id}/delete', 'delete')->name('admin.categories.delete');

});

//Products
Route::controller(ProductController::class)->group(function (){
    Route::get('/products', 'index')->name('admin.products.index');
    Route::get('/products/create', 'create')->name('admin.products.create');
    Route::post('/products', 'store')->name('admin.products.store');
    Route::get('/products/{id}/edit', 'edit')->name('admin.products.edit');
    Route::patch('/products/{id}', 'update')->name('admin.products.update');
    Route::get('products/trash', 'trash')->name('admin.products.trash');
    Route::get('/products/{id}/restore', 'restore')->name('admin.products.restore');
    Route::get('/products/{id}/delete-force', 'deleteForever')->name('admin.products.delete-force');
    Route::get('/products/search', 'search')->name('admin.products.search');
    Route::get('/products/export', 'export')->name('admin.products.export');
    Route::delete('/products/{id}/delete', 'delete')->name('admin.products.delete');
    Route::post('/products/uploads','uploads')->name('admin.products.uploads');

});




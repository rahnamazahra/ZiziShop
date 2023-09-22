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
    Route::get('/users/export-users', 'exportUsers')->name('admin.users.export-users');
    Route::get('/users/{id}', 'delete')->name('admin.users.delete');
});

//Categories
Route::controller(CategoryController::class)->group(function (){
    Route::get('/categories', 'index')->name('admin.categories.index');
    Route::get('/categories/create', 'create')->name('admin.categories.create');
    Route::post('/categories', 'store')->name('admin.categories.store');
    Route::get('/categories/{category}/edit', 'edit')->name('admin.categories.edit');
    Route::patch('/categories/{category}', 'update')->name('admin.categories.update');
    Route::delete('/categories/{category}/delete', 'destroy')->name('admin.categories.delete');
    Route::get('/categories/search', 'search')->name('admin.categories.search');
});

//Products
Route::controller(ProductController::class)->group(function (){
    Route::get('/products', 'index')->name('admin.products.index');
    Route::get('/products/create', 'create')->name('admin.products.create');
    Route::post('/products', 'store')->name('admin.products.store');
    Route::get('/products/{product}/edit', 'edit')->name('admin.products.edit');
    Route::patch('/products/{product}', 'update')->name('admin.products.update');
    Route::delete('/products/{product}/delete', 'destroy')->name('admin.products.delete');
    Route::get('/products/search', 'search')->name('admin.products.search');
});




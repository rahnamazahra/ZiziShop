<?php

use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\UserController;
use Illuminate\Support\Facades\Route;


// Admin Panel
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

//Users
Route::controller(UserController::class)->group(function (){
    Route::get('/users', 'index')->name('admin.users.index');
    Route::get('/users/create', 'create')->name('admin.users.create');
    Route::post('/users', 'store')->name('admin.users.store');
    Route::get('/users/{user}/edit', 'edit')->name('admin.users.edit');
    Route::patch('/users/{user}', 'update')->name('admin.users.update');
    Route::delete('/users/{user}/delete', 'destroy')->name('admin.users.delete');
});

//Categories
Route::controller(UserController::class)->group(function (){
    Route::get('/categories', 'index')->name('admin.categories.index');
    Route::get('/categories/create', 'create')->name('admin.categories.create');
    Route::post('/categories', 'store')->name('admin.categories.store');
    Route::get('/categories/{category}/edit', 'edit')->name('admin.categories.edit');
    Route::patch('/categories/{category}', 'update')->name('admin.categories.update');
    Route::delete('/users/{category}/delete', 'destroy')->name('admin.categories.delete');
});

//Products
Route::controller(UserController::class)->group(function (){
    Route::get('/products', 'index')->name('admin.products.index');
    Route::get('/products/create', 'create')->name('admin.products.create');
    Route::post('/products', 'store')->name('admin.products.store');
    Route::get('/products/{product}/edit', 'edit')->name('admin.products.edit');
    Route::patch('/products/{product}', 'update')->name('admin.products.update');
    Route::delete('/users/{product}/delete', 'destroy')->name('admin.products.delete');
});




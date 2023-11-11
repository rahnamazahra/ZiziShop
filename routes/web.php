<?php

use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\FavoriteProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\site\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\ProductController;

require __DIR__.'/auth.php';

Route::get('/', HomeController::class)->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{slug}/detail', [ProductController::class, 'show'])->name('products.show');
Route::get('category/{slug}', CategoryProductController::class);
Route::get('favorites', FavoriteProductController::class)->middleware('auth');





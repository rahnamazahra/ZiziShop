<?php

use App\Models\Category;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\site\HomeController;
use App\Http\Controllers\CartManagerController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\VerifyPaymentController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\FavoriteProductController;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

require __DIR__.'/auth.php';

Route::get('/', HomeController::class)->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}/detail', [ProductController::class, 'show'])->name('products.show');
Route::get('/view-category/{category:slug}', [CategoryProductController::class, 'index'])->name('category.products');



Route::middleware('auth')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('/add-to-favorites/{product}', [FavoriteController::class, 'store'])->name('add.to.favorites');
    Route::get('/remove-from-favorites/{product}', [FavoriteController::class, 'destroy'])->name('remove.to.favorites');
    Route::get('/cart', [CartManagerController::class, 'index'])->name('cart.index');
    Route::post('/cart/vouch', [CartManagerController::class, 'vouch'])->name('vouch');
    Route::get('/add-to-cart/{product}', [CartManagerController::class, 'addToCart'])->name('add.to.cart');
    Route::delete('/remove-from-cart/{product}', [CartManagerController::class, 'destroy'])->name('remove.to.cart');
    Route::post('checkout', CheckoutController::class)->name('checkout');
    Route::any('verify', VerifyPaymentController::class)->name('verify');
    Route::post('/comment/{product}', [ProductController::class, 'addComment'])->name('add.comment');


});










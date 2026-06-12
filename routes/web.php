<?php

use App\Models\Category;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\CartManagerController;
use App\Http\Controllers\Site\ProductController;
use App\Http\Controllers\VerifyPaymentController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\FavoriteProductController;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;

require __DIR__.'/auth.php';

Route::get('/', HomeController::class);

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/load-more', [ProductController::class, 'loadMore'])->name('products.load-more');
Route::get('/products/{product:slug}/detail', [ProductController::class, 'show'])->name('products.show');
Route::get('/discounts', [ProductController::class, 'discounts'])->name('discounts.index');
Route::any('/custom-order/verify', [\App\Http\Controllers\CustomOrderController::class, 'verify'])->name('custom.order.verify');
Route::post('/custom-order/{product}', [\App\Http\Controllers\CustomOrderController::class, 'store'])->name('custom.order.store');
// صفحه‌ی دسته‌بندی حذف شد؛ نتایج روی تب‌های صفحه‌ی اصلی نمایش داده می‌شود



// ---- Cart routes: available to guests too (session-based cart) ----
Route::get('/cart', [CartManagerController::class, 'index'])->name('cart.index');
Route::post('/cart/vouch', [CartManagerController::class, 'vouch'])->name('vouch');
Route::get('/add-to-cart/{product}', [CartManagerController::class, 'addToCart'])->name('add.to.cart');
Route::post('/cart/increase/{product}', [CartManagerController::class, 'increase'])->name('cart.increase');
Route::post('/cart/decrease/{product}', [CartManagerController::class, 'decrease'])->name('cart.decrease');
Route::delete('/remove-from-cart/{product}', [CartManagerController::class, 'destroy'])->name('remove.to.cart');

// ---- These require login ----
Route::middleware('auth:web')->group(function () {
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::get('/add-to-favorites/{product}', [FavoriteController::class, 'store'])->name('add.to.favorites');
    Route::get('/remove-from-favorites/{product}', [FavoriteController::class, 'destroy'])->name('remove.to.favorites');
    Route::post('/address', [AddressController::class, 'store'])->name('address.store');
    Route::post('/address/{address}/select', [AddressController::class, 'select'])->name('address.select');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/orders/{order}', [AccountController::class, 'orderShow'])->name('account.orders.show');
    Route::get('/account/custom-orders', [\App\Http\Controllers\CustomOrderController::class, 'index'])->name('account.custom-orders');
    Route::get('/custom-order/{customOrder}/pay', [\App\Http\Controllers\CustomOrderController::class, 'pay'])->name('custom.order.pay');
    Route::get('/account/profile', [AccountController::class, 'profile'])->name('account.profile');
    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('checkout', CheckoutController::class)->name('checkout');
    Route::any('verify', VerifyPaymentController::class)->name('verify');
    Route::post('/comment/{product}', [ProductController::class, 'addComment'])->name('add.comment');


});










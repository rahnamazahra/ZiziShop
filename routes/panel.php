<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Panel\{UserController, ColorController, SizeController, CategoryController, ProductController, VoucherController, OrderController, DashboardController, CustomOrderController, ExpenseController};

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
    Route::post('/categories/export', 'export')->name('categories.export');
});

//Products
Route::controller(ProductController::class)->name('admin.')->group(function () {
    Route::put('/products/{product}/restore', 'restore')->withTrashed()->name('products.restore');
    Route::post('/products/{product}/force-delete', 'forceDelete')->withTrashed()->name('products.force-delete');
    Route::get('/products/export', 'export')->name('products.export');
});

Route::name('admin.')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('categories', CategoryController::class)->scoped(['category' => 'slug']);
    Route::resource('products', ProductController::class)->scoped(['product' => 'slug']);
    Route::resource('vouchers', VoucherController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('expenses', ExpenseController::class)->except(['show']);

});

// نمایش/پنهان‌سازی موارد تستی (فقط ادمین)
Route::post('/toggle-demo', function () {
    session(['gr_show_demo' => ! session('gr_show_demo', false)]);
    return back();
})->name('admin.toggle-demo');

// Custom Orders (سفارش‌های ویژه)
Route::controller(CustomOrderController::class)->name('admin.')->prefix('custom-orders')->group(function () {
    Route::get('/', 'index')->name('custom-orders.index');
    Route::get('/{customOrder}', 'show')->name('custom-orders.show');
    Route::post('/{customOrder}/approve', 'approve')->name('custom-orders.approve');
    Route::post('/{customOrder}/reject', 'reject')->name('custom-orders.reject');
});




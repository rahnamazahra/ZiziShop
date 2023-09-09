<?php

use Illuminate\Support\Facades\Route;


// Admin Panel
Route::controller(DashboardController::class)->group(function () {
    Route::get('/')->name('admin.dashboard');
});

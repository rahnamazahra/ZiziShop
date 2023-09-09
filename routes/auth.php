<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('auth.login.form');
    Route::post('login', [LoginController::class, 'checkLogin'])->name('auth.login.verify');
});

Route::middleware('auth')->group(function () {

    Route::post('logout', [LoginController::class, 'destroy'])->name('auth.logout');
});

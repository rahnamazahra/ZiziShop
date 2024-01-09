<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SendSMSController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyMobileSMSController;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('auth.login.form');
    Route::post('login', [LoginController::class, 'checkLogin'])->name('auth.login.verify');
    Route::get('register', [RegisteredUserController::class, 'create'])->name('auth.register.form');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('auth.register.store');
    Route::get('send-code', SendSMSController::class)->name('auth.mobile.sendCode');
    Route::post('mobile-verify', VerifyMobileSMSController::class)->name('auth.mobile.verify');
});

Route::middleware('auth')->group(function () {

    Route::get('logout', [LoginController::class, 'destroy'])->name('auth.logout');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Applications\User\Controllers\UserController;

Route::post('register', [UserController::class, 'register'])->name('user.register');

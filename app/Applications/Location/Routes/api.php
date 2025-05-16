<?php

use Illuminate\Support\Facades\Route;
use App\Applications\Location\Controllers\LocationController;

Route::get('/provinces', [LocationController::class, 'provinces']);
Route::get('/provinces/{province}/cities', [LocationController::class, 'cities']);

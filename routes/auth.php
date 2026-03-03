<?php

use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
    Route::post('/login', 'store')->name('login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::post('/register', 'store')->name('register');
});

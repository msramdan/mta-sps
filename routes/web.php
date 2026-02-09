<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'web'])->group(function () {
    Route::controller(App\Http\Controllers\DashboardController::class)->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
    });
    Route::get('/profile', App\Http\Controllers\ProfileController::class)->name('profile');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleAndPermissionController::class);
});


Route::controller(App\Http\Controllers\Frontend\WebController::class)->group(function () {
    Route::get('/', 'index')->name('web.landing.page');
});

Route::resource('banks', App\Http\Controllers\BankController::class)->middleware('auth');
Route::resource('merchants', App\Http\Controllers\MerchantController::class)->middleware('auth');
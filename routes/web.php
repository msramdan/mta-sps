<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    DashboardController,
    ProfileController,
    UserController,
    RoleAndPermissionController,
    BankController,
    MerchantController,
    TarikSaldoController,
    SettingMerchantController
};
use App\Http\Controllers\Frontend\WebController;

Route::controller(WebController::class)->group(function () {
    Route::get('/', 'index')->name('web.landing.page');
    Route::post('/register-merchant', 'registerMerchant')->name('web.register.merchant');
});

// Authentication Routes (Protected)
Route::middleware(['auth', 'web'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', ProfileController::class)->name('profile');

    // User Management
    Route::resource('users', UserController::class);

    // Role & Permission Management
    Route::resource('roles', RoleAndPermissionController::class);

    // Bank Management
    Route::resource('banks', BankController::class);

    // Merchant Management
    Route::resource('merchants', MerchantController::class);
    Route::post('/merchants/{merchant}/review', [MerchantController::class, 'review'])
        ->name('merchants.review');

    Route::get('/setting-merchant', [SettingMerchantController::class, 'index'])
        ->name('setting-merchant.index');
    Route::put('/setting-merchant', [SettingMerchantController::class, 'update'])
        ->name('setting-merchant.update');

    // Tarik Saldo Management
    Route::resource('tarik-saldos', TarikSaldoController::class);
});

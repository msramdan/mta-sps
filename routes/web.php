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
    SettingMerchantController,
    TransaksiController,
    ApiDocumentationController,
    LogGenerateQrController,
    LogCallbackController
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

    // System Log
    Route::get('/log-generate-qrs', [LogGenerateQrController::class, 'index'])->name('log-generate-qrs.index');
    Route::get('/log-generate-qrs/{logGenerateQr}', [LogGenerateQrController::class, 'show'])->name('log-generate-qrs.show');
    Route::get('/log-callbacks', [LogCallbackController::class, 'index'])->name('log-callbacks.index');
    Route::get('/log-callbacks/{logCallback}', [LogCallbackController::class, 'show'])->name('log-callbacks.show');

    // Bank Management
    Route::resource('banks', BankController::class);

    // Merchant Management
    Route::resource('merchants', MerchantController::class);
    Route::post('/merchants/{merchant}/review', [MerchantController::class, 'review'])
        ->name('merchants.review');
    Route::get('/merchants-search', [MerchantController::class, 'search'])
        ->name('merchants.search');

    Route::get('/setting-merchant', [SettingMerchantController::class, 'index'])
        ->name('setting-merchant.index');
    Route::put('/setting-merchant', [SettingMerchantController::class, 'update'])
        ->name('setting-merchant.update');
    Route::post('/switch-merchant', [SettingMerchantController::class, 'switchMerchant'])
        ->name('switch-merchant');

    // Transaksi Management
    Route::get('/transaksis-summary', [TransaksiController::class, 'summary'])->name('transaksis.summary');
    Route::resource('transaksis', TransaksiController::class);

    // Tarik Saldo Management
    Route::get('/tarik-saldos-merchant-data', [TarikSaldoController::class, 'getMerchantData'])
        ->name('tarik-saldos.merchant-data');
    Route::post('/tarik-saldos/{tarikSaldo}/cancel', [TarikSaldoController::class, 'cancel'])
        ->name('tarik-saldos.cancel');
    Route::resource('tarik-saldos', TarikSaldoController::class);

    // Simulator Management
    Route::get('/simulators', [App\Http\Controllers\SimulatorController::class, 'index'])
        ->name('simulators.index');
    Route::post('/simulators/generate-qris', [App\Http\Controllers\SimulatorController::class, 'generateQris'])
        ->name('simulators.generate-qris');

    // API Documentation
    Route::get('/api-documentation', [ApiDocumentationController::class, 'index'])
        ->name('api-documentation.index');
});

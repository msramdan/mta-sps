<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginOtpController;
use App\Http\Controllers\{
    ActivityLogController,
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
    LogCallbackController,
    LogResendCallbackController,
    LogQueryPaymentStatusController,
    LogTokenB2bController
};
use App\Http\Controllers\Frontend\WebController;

// Login OTP verification (before auth)
Route::middleware(['web'])->group(function () {
    Route::get('/login-otp', [LoginOtpController::class, 'showForm'])->name('login-otp.form');
    Route::post('/login-otp', [LoginOtpController::class, 'verify'])->name('login-otp.verify');
    Route::post('/login-otp/resend', [LoginOtpController::class, 'resend'])->name('login-otp.resend');
});

Route::controller(WebController::class)->group(function () {
    Route::get('/', 'index')->name('web.landing.page');
    Route::get('/api-docs', 'apiDocs')->name('web.api-docs');
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
    Route::delete('/log-generate-qrs/{logGenerateQr}', [LogGenerateQrController::class, 'destroy'])->name('log-generate-qrs.destroy');
    Route::post('/log-generate-qrs/bulk-destroy', [LogGenerateQrController::class, 'bulkDestroy'])->name('log-generate-qrs.bulk-destroy');
    Route::get('/log-callbacks', [LogCallbackController::class, 'index'])->name('log-callbacks.index');
    Route::get('/log-callbacks/{logCallback}', [LogCallbackController::class, 'show'])->name('log-callbacks.show');
    Route::delete('/log-callbacks/{logCallback}', [LogCallbackController::class, 'destroy'])->name('log-callbacks.destroy');
    Route::post('/log-callbacks/bulk-destroy', [LogCallbackController::class, 'bulkDestroy'])->name('log-callbacks.bulk-destroy');
    Route::get('/log-resend-callbacks', [LogResendCallbackController::class, 'index'])->name('log-resend-callbacks.index');
    Route::get('/log-resend-callbacks/{logResendCallback}', [LogResendCallbackController::class, 'show'])->name('log-resend-callbacks.show');
    Route::delete('/log-resend-callbacks/{logResendCallback}', [LogResendCallbackController::class, 'destroy'])->name('log-resend-callbacks.destroy');
    Route::post('/log-resend-callbacks/bulk-destroy', [LogResendCallbackController::class, 'bulkDestroy'])->name('log-resend-callbacks.bulk-destroy');
    Route::get('/log-query-payment-status', [LogQueryPaymentStatusController::class, 'index'])->name('log-query-payment-status.index');
    Route::get('/log-query-payment-status/{logQueryPaymentStatus}', [LogQueryPaymentStatusController::class, 'show'])->name('log-query-payment-status.show');
    Route::delete('/log-query-payment-status/{logQueryPaymentStatus}', [LogQueryPaymentStatusController::class, 'destroy'])->name('log-query-payment-status.destroy');
    Route::post('/log-query-payment-status/bulk-destroy', [LogQueryPaymentStatusController::class, 'bulkDestroy'])->name('log-query-payment-status.bulk-destroy');
    Route::get('/log-token-b2b', [LogTokenB2bController::class, 'index'])->name('log-token-b2b.index');
    Route::get('/log-token-b2b/{logTokenB2b}', [LogTokenB2bController::class, 'show'])->name('log-token-b2b.show');
    Route::delete('/log-token-b2b/{logTokenB2b}', [LogTokenB2bController::class, 'destroy'])->name('log-token-b2b.destroy');
    Route::post('/log-token-b2b/bulk-destroy', [LogTokenB2bController::class, 'bulkDestroy'])->name('log-token-b2b.bulk-destroy');

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/{activityLog}', [ActivityLogController::class, 'show'])->name('activity-logs.show');

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
    Route::post('/transaksis/{transaksi}/resend-callback', [TransaksiController::class, 'resendCallback'])->name('transaksis.resend-callback');
    Route::resource('transaksis', TransaksiController::class);

    // Tarik Saldo Management
    Route::get('/tarik-saldos-summary', [TarikSaldoController::class, 'summary'])
        ->name('tarik-saldos.summary');
    Route::get('/tarik-saldos-merchant-data', [TarikSaldoController::class, 'getMerchantData'])
        ->name('tarik-saldos.merchant-data');
    Route::post('/tarik-saldos/{tarikSaldo}/cancel', [TarikSaldoController::class, 'cancel'])
        ->name('tarik-saldos.cancel');
    Route::post('/tarik-saldos/{tarikSaldo}/status', [TarikSaldoController::class, 'updateStatus'])
        ->name('tarik-saldos.update-status');
    Route::post('/tarik-saldos/{tarikSaldo}/confirm', [TarikSaldoController::class, 'confirm'])
        ->name('tarik-saldos.confirm');
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

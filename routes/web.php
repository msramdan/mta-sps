<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginOtpController;
use App\Http\Controllers\{
    CompanyController,
    DashboardController,
    ProfileController,
    UserController,
    RoleAndPermissionController,
};

// Login OTP verification (before auth)
Route::middleware(['web'])->group(function () {
    Route::get('/login-otp', [LoginOtpController::class, 'showForm'])->name('login-otp.form');
    Route::post('/login-otp', [LoginOtpController::class, 'verify'])->name('login-otp.verify');
    Route::post('/login-otp/resend', [LoginOtpController::class, 'resend'])->name('login-otp.resend');
});

// Redirect landing to login
Route::get('/', fn () => auth()->check() ? redirect()->route('dashboard') : redirect()->route('login'))->name('home');

// Register disabled - redirect to login
Route::get('/register', fn () => redirect()->route('login'))->name('register');

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

    // Company (Multi-company)
    Route::resource('companies', CompanyController::class);
});

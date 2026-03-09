<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginOtpController;
use App\Http\Controllers\{
    CompanyController,
    DashboardController,
    JadwalTeknisiController,
    KunjunganSalesController,
    LaporanController,
    PenagihanController,
    ProfileController,
    RoleAndPermissionController,
    SphController,
    SpkController,
    SwitchCompanyController,
    UserController,
    WorkingController,
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

    // Kunjungan Sales
    Route::resource('kunjungan-sales', KunjunganSalesController::class);

    // SPK/PO
    Route::resource('spk', SpkController::class);

    // Jadwal Teknisi
    Route::get('jadwal-teknisi/events', [JadwalTeknisiController::class, 'events'])->name('jadwal-teknisi.events');
    Route::resource('jadwal-teknisi', JadwalTeknisiController::class);

    // Working / Progress Pekerjaan
    Route::get('working', [WorkingController::class, 'index'])->name('working.index');
    Route::get('working/{jadwal_teknisi}', [WorkingController::class, 'show'])->name('working.show');
    Route::post('working/{jadwal_teknisi}', [WorkingController::class, 'store'])->name('working.store');

    // Proses Penagihan
    Route::get('penagihan', [PenagihanController::class, 'index'])->name('penagihan.index');
    Route::get('penagihan/spk/{spk}', [PenagihanController::class, 'show'])->name('penagihan.show');
    Route::get('penagihan/{penagihan}/laporan', [PenagihanController::class, 'laporan'])->name('penagihan.laporan');

    // Cetak Laporan (menu terpisah)
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index')->middleware('permission:penagihan view');
    Route::put('penagihan/{penagihan}', [PenagihanController::class, 'update'])->name('penagihan.update');
    Route::post('penagihan/{penagihan}/upload/{jenis_dokumen}', [PenagihanController::class, 'upload'])->name('penagihan.upload');
    Route::get('penagihan/{penagihan}/dokumen/{dokumen}/download', [PenagihanController::class, 'download'])->name('penagihan.download');

    // SPH (custom routes first agar tidak tertimpa resource)
    Route::get('sph/{sph}/revision', [SphController::class, 'revision'])->name('sph.revision');
    Route::post('sph/{sph}/revision', [SphController::class, 'storeRevision'])->name('sph.store-revision');
    Route::get('sph/{sph}/detail/{detail}/download', [SphController::class, 'downloadDetail'])->name('sph.download-detail');
    Route::resource('sph', SphController::class)->except(['edit', 'update']);

    // Switch perusahaan (session)
    Route::post('/switch-company', SwitchCompanyController::class)->name('switch-company');
});

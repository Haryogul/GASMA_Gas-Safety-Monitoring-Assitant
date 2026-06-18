<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController; 
use App\Http\Controllers\RegisterController; 
use App\Http\Controllers\PemantauanGasController;
use App\Http\Controllers\PemantauanSuhuController;
use App\Http\Controllers\PemantauanCahayaController;
use App\Http\Controllers\NotifikasiInsidenController;
use App\Http\Controllers\PemantauanLokasiController;
use App\Http\Controllers\RiwayatPemantauanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\PengaturanSistemController;

// TAMBAHKAN: Import Controller untuk Forgot Password
use App\Http\Controllers\ForgotPasswordController; 


// =======================================================
// 1. RUTE AUTHENTIKASI (LOGIN, REGISTER, & LUPA PASSWORD)
// =======================================================

// Login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

// Register
Route::get('/register', [RegisterController::class, 'index'])->name('register'); 
Route::post('/register', [RegisterController::class, 'store'])->name('register.post'); 

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// --- START: RUTE LUPA PASSWORD ---
// 1. Menampilkan form input email (Halaman awal Lupa Password)
Route::get('/forgot-password', function () {
    return view('auth.forgot-password-form');
})->name('password.request'); 

// 2. Memproses pengiriman link/logika reset awal (POST)
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
    ->name('password.email');

// 3. TAMBAHAN: Menampilkan form untuk input PASSWORD BARU (setelah klik link email/lanjut)
// Rute ini penting agar user punya tempat untuk mengetikkan sandi barunya
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// 4. TAMBAHAN: Memproses update password ke database (POST)
Route::post('/reset-password', [ForgotPasswordController::class, 'updatePassword'])
    ->name('password.update.post');
// --- END: RUTE LUPA PASSWORD ---


// =======================================================
// 2. RUTE TERLINDUNG (MEMBUTUHKAN LOGIN)
// Gunakan middleware 'auth' untuk melindungi semua rute ini
// =======================================================

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/pemantauan_gas', [PemantauanGasController::class, 'index'])->name('pemantauan_gas');
    Route::get('/pemantauan_suhu', [PemantauanSuhuController::class, 'index'])->name('pemantauan_suhu');
    Route::get('/pemantauan_lokasi', [PemantauanLokasiController::class, 'index'])->name('pemantauan_lokasi');
    Route::get('/pemantauan_cahaya', [PemantauanCahayaController::class, 'index'])->name('pemantauan_cahaya');
    Route::get('/notifikasi_insiden', [NotifikasiInsidenController::class, 'index'])->name('notifikasi_insiden');
    Route::get('/riwayat_pemantauan', [RiwayatPemantauanController::class, 'index'])->name('riwayat_pemantauan');
    Route::get('/pengguna', [PenggunaController::class, 'index'])->name('pengguna');
    Route::get('/pengaturan_sistem', [PengaturanSistemController::class, 'index'])->name('pengaturan_sistem');
});
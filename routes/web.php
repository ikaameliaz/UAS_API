<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ComplaintController;
use App\Http\Middleware\RoleMiddleware;

// Halaman utama (landing page)
Route::get('/', function () {
    return view('main');
})->name('main');

// ==================== AUTH ==================== //

// Register Mahasiswa
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Login untuk Mahasiswa/Admin
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ==================== MAHASISWA ==================== //

Route::middleware(['auth', RoleMiddleware::class . ':mahasiswa'])->group(function () {
    // Dashboard Mahasiswa
    Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard.mahasiswa');

    // Buat dan Lihat Pengaduan
    Route::get('/pengaduan/create', [ComplaintController::class, 'create'])->name('pengaduan.create');
    Route::post('/pengaduan', [ComplaintController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan/{id}', [ComplaintController::class, 'show'])->name('pengaduan.show');
});

// ==================== ADMIN ==================== //

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    // Dashboard Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('dashboard.admin');

    // Lihat & Tanggapi Pengaduan
    Route::get('/admin/pengaduan/{id}', [AdminController::class, 'show'])->name('admin.pengaduan.show');
    Route::post('/admin/pengaduan/{id}/tanggapan', [AdminController::class, 'tanggapi'])->name('admin.pengaduan.tanggapi');
});

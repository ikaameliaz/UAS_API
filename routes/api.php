<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\ApiKeyMahasiswa; // ⬅️ Tambah ini!

// 🔐 AUTH ROUTES
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register/admin', [AuthController::class, 'registerAdmin']);
Route::post('/register/mahasiswa', [AuthController::class, 'registerMahasiswa']);

// 🌐 ROUTES UNTUK SIAPA PUN YANG LOGIN (admin / mahasiswa)
Route::middleware(['multi.guard'])->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/cek-token', function () {
        return response()->json([
            'user' => auth()->user(),
            'guard' => auth()->getDefaultDriver(),
        ]);
    });
});

// 👮‍♂️ RUTE KHUSUS ADMIN
Route::middleware(['multi.guard', 'auth:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/{id}', [AdminController::class, 'show']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::put('/admin/{id}', [AdminController::class, 'update']);
    Route::delete('/admin/{id}', [AdminController::class, 'destroy']);

    Route::get('/kategori', [CategoryController::class, 'index']);
    Route::post('/kategori', [CategoryController::class, 'store']);
    Route::put('/kategori/{id}', [CategoryController::class, 'update']);
    Route::delete('/kategori/{id}', [CategoryController::class, 'destroy']);

    Route::get('/tanggapan', [CommentController::class, 'index']);
    Route::get('/tanggapan/{id}', [CommentController::class, 'show']);
    Route::post('/tanggapan/{complaint_id}', [CommentController::class, 'store']);
    Route::put('/tanggapan/{id}', [CommentController::class, 'update']);
    Route::delete('/tanggapan/{id}', [CommentController::class, 'destroy']);

    Route::get('/admin-only', fn () => response()->json(['message' => 'Halo Admin!']));
});

// 🎓 RUTE KHUSUS MAHASISWA
Route::middleware(['multi.guard', 'auth:mahasiswa'])->group(function () {
    Route::post('/logout/mahasiswa', [AuthController::class, 'logout']);
    Route::get('/mahasiswa/me', [AuthController::class, 'me']);

    Route::get('/mahasiswa', [MahasiswaController::class, 'index']);
    Route::get('/mahasiswa/{id}', [MahasiswaController::class, 'show']);
    Route::post('/mahasiswa', [MahasiswaController::class, 'store']);
    Route::put('/mahasiswa/{id}', [MahasiswaController::class, 'update']);
    Route::delete('/mahasiswa/{id}', [MahasiswaController::class, 'destroy']);

    Route::get('/pengaduan', [ComplaintController::class, 'index']);
    Route::get('/pengaduan/{id}', [ComplaintController::class, 'show']);
    Route::post('/pengaduan', [ComplaintController::class, 'store']);
    Route::put('/pengaduan/{id}', [ComplaintController::class, 'update']);
    Route::delete('/pengaduan/{id}', [ComplaintController::class, 'destroy']);

    Route::get('/mahasiswa-only', fn () => response()->json(['message' => 'Halo Mahasiswa!']));
});

// ✅ BASIC AUTH ENDPOINT
Route::get('/basic-auth-check', function () {
    return response()->json([
        'message' => 'Basic auth works!',
        'timestamp' => now()
    ]);
})->middleware('auth.basic:admin_basic'); // pastikan guard "admin_basic" dikonfigurasi

// ✅ API KEY AUTH (untuk Mahasiswa) – Gunakan header: Authorization: Bearer <API_KEY>
Route::middleware(ApiKeyMahasiswa::class)->group(function () {
    Route::get('/apikey/mahasiswa-check', function () {
        return response()->json(['message' => 'API key mahasiswa valid!']);
    });
});

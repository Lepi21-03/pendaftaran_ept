<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\MahasiswaController;
use App\Http\Controllers\Api\XenditWebhookController;

// HALAMAN AWAL → halaman ujian
Route::get('/', [MahasiswaController::class, 'ujian'])
    ->name('mahasiswa.ujian.index');

// group mahasiswa
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {

    // halaman ujian
    Route::get('/ujian', [MahasiswaController::class, 'ujian'])
        ->name('ujian.index');

    // halaman login
    Route::get('/login', [MahasiswaController::class, 'login'])
        ->name('login');

    // halaman dokumen/sertifikat
    Route::get('/dokumen', [MahasiswaController::class, 'dokumen'])
        ->name('dokumen');

    // halaman daftar
    Route::get('/daftar', [MahasiswaController::class, 'daftar'])
        ->name('daftar.index');

    Route::post('/daftar', [MahasiswaController::class, 'store'])
        ->name('daftar.store');

    // ✅ Route ini dipanggil Xendit saat user berhasil bayar
    Route::get('/pembayaran/sukses', [MahasiswaController::class, 'pembayaranSukses'])
        ->name('pembayaran.sukses');

    // Logout
    Route::post('/logout', [MahasiswaController::class, 'logout'])
        ->name('logout');
});

// =============================================
// WEBHOOK XENDIT (Notifikasi Pembayaran)
// CSRF sudah di-exclude di bootstrap/app.php
// =============================================
Route::post('/webhook/xendit', [XenditWebhookController::class, 'handle'])
    ->name('webhook.xendit');
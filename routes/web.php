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

    Route::post('/login', [MahasiswaController::class, 'loginStore'])
        ->name('login.store');

    // ================================================================
    // RESET PASSWORD
    // ================================================================
    Route::get('/forgot-password', [\App\Http\Controllers\mahasiswa\PasswordResetController::class, 'showLinkRequestForm'])
        ->name('password.request');

    Route::post('/forgot-password', [\App\Http\Controllers\mahasiswa\PasswordResetController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    Route::get('/reset-password/{token}', [\App\Http\Controllers\mahasiswa\PasswordResetController::class, 'showResetForm'])
        ->name('password.reset');

    Route::post('/reset-password', [\App\Http\Controllers\mahasiswa\PasswordResetController::class, 'reset'])
        ->name('password.update');

    // ================================================================
    // VERIFIKASI EMAIL
    // ================================================================

    // Halaman "Cek Email Anda" (setelah registrasi)
    Route::get('/verifikasi/cek-email', [MahasiswaController::class, 'cekEmail'])
        ->name('verifikasi.cek-email');

    // Handle klik link verifikasi (signed URL, expire 5 menit)
    // Middleware 'signed' memvalidasi signature dan expiry secara otomatis
    Route::get('/verifikasi/email/{mahasiswa_id}/{daftar_id}', [MahasiswaController::class, 'verifikasiEmail'])
        ->name('verifikasi.email')
        ->middleware('signed');

    // Kirim ulang email verifikasi
    Route::post('/verifikasi/resend', [MahasiswaController::class, 'resendVerifikasi'])
        ->name('verifikasi.resend');

    // API: Cek status pembayaran (dipanggil via AJAX polling dari halaman cek-email)
    Route::get('/verifikasi/cek-status/{daftar_id}', [MahasiswaController::class, 'cekStatusPembayaran'])
        ->name('verifikasi.cek-status');

    // ================================================================
    // DOKUMEN — dilindungi middleware (email verified + pembayaran success)
    // ================================================================
    Route::middleware(['email.verified', 'pembayaran.success'])->group(function () {
        // halaman dokumen/sertifikat
        Route::get('/dokumen', [MahasiswaController::class, 'dokumen'])
            ->name('dokumen');

        // Download Kartu Ujian sebagai PDF
        Route::get('/dokumen/kartu-ujian/download', [MahasiswaController::class, 'downloadKartuUjian'])
            ->name('dokumen.kartu-ujian.download');

        // Download Sertifikat sebagai PDF
        Route::get('/dokumen/sertifikat/download', [MahasiswaController::class, 'downloadSertifikat'])
            ->name('dokumen.sertifikat.download');
    });

    // halaman daftar
    Route::get('/daftar', [MahasiswaController::class, 'daftar'])
        ->name('daftar.index');

    Route::post('/daftar', [MahasiswaController::class, 'store'])
        ->name('daftar.store');

    // Route dipanggil Xendit saat user berhasil bayar (redirect dari Xendit)
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

// =============================================
// DOWNLOAD SERTIFIKAT LAMA (dari halaman import nilai — tetap dipertahankan)
// =============================================
Route::get('/sertifikat/{mahasiswa}/download', function (\App\Models\Mahasiswa $mahasiswa) {
    return response()->streamDownload(function () use ($mahasiswa) {
        echo \Barryvdh\DomPDF\Facade\Pdf::loadView('mahasiswa.dokumen.sertifikat', ['mahasiswa' => $mahasiswa])
            ->setPaper('a4', 'portrait')
            ->output();
    }, 'Sertifikat-EPT-' . $mahasiswa->nim . '.pdf');
})->name('sertifikat.download');
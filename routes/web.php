<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\mahasiswa\MahasiswaController;

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

    // halaman daftar
    Route::get('/daftar', [MahasiswaController::class, 'daftar'])
        ->name('daftar.index');

    Route::post('/daftar', [MahasiswaController::class, 'store'])
        ->name('daftar.store');
});
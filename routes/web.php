<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// admin routes










// mahasiswa routes
Route::get('/mahasiswa/daftar', function () {
    return view('mahasiswa.daftar.index');
})->name('mahasiswa.daftar');

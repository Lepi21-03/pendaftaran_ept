<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migration untuk menambahkan index pada kolom 'email' di tabel mahasiswas.
 *
 * TUJUAN:
 * - Mempercepat query login (WHERE email = ?)
 * - Mempercepat pencarian mahasiswa berdasarkan email
 * - Kolom 'nim' sudah unique (otomatis ter-index)
 * - Kolom 'email' belum memiliki index
 *
 * DAMPAK: Non-breaking, hanya menambahkan index tanpa mengubah struktur tabel.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->index('email', 'idx_mahasiswas_email');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropIndex('idx_mahasiswas_email');
        });
    }
};

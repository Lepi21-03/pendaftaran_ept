<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom password dan email_verified_at ke tabel mahasiswas.
     * - password: nullable agar user lama yang belum punya password tidak error
     * - email_verified_at: untuk tracking apakah email sudah diverifikasi
     */
    public function up(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->string('password')->nullable()->after('email');
            $table->timestamp('email_verified_at')->nullable()->after('password');
        });
    }

    /**
     * Rollback: hapus kolom password dan email_verified_at.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['password', 'email_verified_at']);
        });
    }
};

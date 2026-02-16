<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('daftar', function (Blueprint $table) {
            $table->id();

             $table->unsignedBigInteger('id_ujian');

            $table->string('nim');
            $table->string('nama_lengkap');
            $table->date('bod');
            $table->string('prodi');
            $table->string('no_telp', 12);
            $table->string('email');
            $table->timestamps();

             $table->foreign('id_ujian')
                  ->references('id')
                  ->on('ujian')
                  ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar');
    }
};

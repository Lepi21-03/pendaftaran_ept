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
        Schema::create('kartu_ujian', function (Blueprint $table) {
            $table->id();
            $table->string('nim');
            $table->string('nama_lengkap');
            $table->date('bod');
            $table->string('prodi');

            $table->unsignedBigInteger('id_ujian');

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
        Schema::dropIfExists('kartu_ujian');
    }
};

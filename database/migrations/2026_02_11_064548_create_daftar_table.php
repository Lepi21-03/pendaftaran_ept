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
        Schema::create('daftars', function (Blueprint $table) {
    $table->id();

    $table->foreignId('ujian_id')
          ->constrained('ujians')
          ->cascadeOnDelete();

    $table->string('nim')->index();
    $table->string('nama_lengkap');
    $table->date('bod');
    $table->string('prodi');
    $table->string('no_telp', 15);
    $table->string('email')->index();

    $table->string('status')->default('pending');

    $table->timestamps();

    $table->unique(['ujian_id', 'email']);
});
    }
  public function down(): void
    {
        Schema::dropIfExists('daftars');
    }
};
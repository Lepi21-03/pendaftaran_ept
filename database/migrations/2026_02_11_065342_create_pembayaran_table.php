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
      Schema::create('pembayarans', function (Blueprint $table) {
    $table->id();

    $table->foreignId('daftar_id')
          ->constrained('daftars')
          ->cascadeOnDelete();

    $table->integer('amount');
    $table->string('status')->default('pending');
    $table->string('reference')->unique()->nullable();

    $table->timestamps();
});
    }
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};



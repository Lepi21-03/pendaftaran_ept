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
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->integer('score_listening')->nullable()->after('score');
            $table->integer('score_structure')->nullable()->after('score_listening');
            $table->integer('score_reading')->nullable()->after('score_structure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['score_listening', 'score_structure', 'score_reading']);
        });
    }
};

<?php

namespace App\Services;

use App\Models\Ujian;

class UjianService
{
    /**
     * Mengambil daftar ujian yang sedang dibuka (status 'open').
     */
    public function getOpenUjian()
    {
        return Ujian::with('pengawas')
            ->where('status', 'open')
            ->orderBy('tanggal_ujian', 'desc')
            ->get();
    }
}

<?php

namespace App\Services;

use App\Models\Ujian;
use App\Models\Daftar;
use Illuminate\Support\Facades\DB;

class PendaftaranService
{
    public function daftar(array $data): Daftar
    {
        return DB::transaction(function () use ($data) {

            // Kunci baris ujian (anti race condition)
            $ujian = Ujian::where('id', $data['ujian_id'])
                ->lockForUpdate()
                ->firstOrFail();

            // Cek status ujian
            if ($ujian->status !== 'open') {
                throw new \Exception('Ujian tidak tersedia');
            }

            // Cek kuota
            if ($ujian->daftars()->count() >= $ujian->kuota) {
                throw new \Exception('Kuota penuh');
            }

            // Simpan pendaftaran (FIELD TERKONTROL)
            $pendaftaran = Daftar::create([
                'ujian_id'     => $ujian->id,
                'nim'          => $data['nim'],
                'nama_lengkap' => $data['nama_lengkap'],
                'bod'          => $data['bod'],
                'prodi'        => $data['prodi'],
                'no_telp'      => $data['no_telp'],
                'email'        => $data['email'],
            ]);

            // Tutup ujian otomatis jika kuota penuh setelah pendaftaran ini
            if ($ujian->daftars()->count() >= $ujian->kuota) {
                $ujian->update(['status' => 'closed']);
            }

            return $pendaftaran;
        });
    }
}

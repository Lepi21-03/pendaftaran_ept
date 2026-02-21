<?php

namespace App\Services;

use App\Models\Daftar;
use App\Models\Pembayaran;
use App\Models\KartuUjian;
use Illuminate\Support\Facades\DB;

class PembayaranService
{
    public function bayarDanGenerateKartu(int $daftarId): KartuUjian
    {
        return DB::transaction(function () use ($daftarId) {

            // Ambil pendaftaran
            $daftar = Daftar::lockForUpdate()->findOrFail($daftarId);

            // 1️⃣ Cegah double bayar
            if ($daftar->pembayaran) {
                throw new \Exception('Pendaftaran ini sudah dibayar');
            }

            // 2️⃣ Simpan pembayaran
            Pembayaran::create([
                'daftar_id' => $daftar->id,
                'ujian_id'  => $daftar->ujian_id,
                'status'    => 'paid',
            ]);

            // 3️⃣ Cegah double kartu
            if ($daftar->kartuUjian) {
                throw new \Exception('Kartu ujian sudah pernah dibuat');
            }

            // 4️⃣ Generate kartu ujian
            return KartuUjian::create([
                'nim'          => $daftar->nim,
                'nama_lengkap' => $daftar->nama_lengkap,
                'bod'          => $daftar->bod,
                'prodi'        => $daftar->prodi,
                'id_ujian'     => $daftar->ujian_id,
            ]);
        });
    }
}
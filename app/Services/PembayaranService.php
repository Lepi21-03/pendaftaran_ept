<?php

namespace App\Services;

use App\Models\Daftar;
use App\Models\Pembayaran;
use App\Models\KartuUjian;
use App\Models\Mahasiswa;
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
            $kartu = KartuUjian::create([
                'daftar_id'     => $daftar->id,
                'nomor_peserta' => 'EPT-' . date('Ym') . '-' . str_pad($daftar->id, 4, '0', STR_PAD_LEFT),
                'generated_at'  => now(),
            ]);

            // 5️⃣ Simpan atau Update Data ke Tabel Mahasiswa (INTI)
            Mahasiswa::updateOrCreate(
                ['nim' => $daftar->nim], // Cari berdasarkan NIM
                [
                    'name'  => $daftar->nama_lengkap,
                    'prodi' => $daftar->prodi,
                    'email' => $daftar->email,
                    'phone' => $daftar->no_telp,
                ]
            );

            // 6️⃣ Update status daftar jadi success
            $daftar->status = 'success';
            $daftar->save();

            return $kartu;
        });
    }
}
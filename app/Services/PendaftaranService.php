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

            // Cek apakah sudah ada dengan email ini di ujian_id yang sama
            $existing = Daftar::where('ujian_id', $ujian->id)
                ->where('email', $data['email'])
                ->first();

            if ($existing) {
                if ($existing->status === 'success') {
                    throw new \Exception('Email ini sudah terdaftar dan berhasil melakukan pembayaran pada ujian ini.');
                }

                // Jika masih pending, kita bisa update datanya
                $existing->update([
                    'nim'          => $data['nim'],
                    'nama_lengkap' => $data['nama_lengkap'],
                    'bod'          => $data['bod'],
                    'prodi'        => $data['prodi'],
                    'no_telp'      => $data['no_telp'],
                ]);

                return $existing;
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

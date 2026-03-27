<?php

namespace App\Services;

use App\Models\Ujian;
use App\Models\Daftar;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\VerifikasiEmailMail;

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
                    'tempat_lahir' => $data['tempat_lahir'],
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
                'tempat_lahir' => $data['tempat_lahir'],
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

    /**
     * Membungkus proses daftar dengan simpan Akun Mahasiswa
     * dan Pengiriman Email Verifikasi.
     */
    public function daftarWithAccount(array $validated): Daftar
    {
        // 1. Simpan pendaftaran
        $pendaftaran = $this->daftar($validated);

        // 2. Buat/update Mahasiswa dengan password (Otomatis di-hash oleh cast di model)
        $mahasiswa = Mahasiswa::updateOrCreate(
            ['nim' => $validated['nim']],
            [
                'name'     => $validated['nama_lengkap'],
                'prodi'    => $validated['prodi'],
                'email'    => $validated['email'],
                'phone'    => $validated['no_telp'],
                'password' => $validated['password'],
            ]
        );

        // 3. Kirim email verifikasi
        $this->sendVerificationEmail($mahasiswa, $pendaftaran);

        return $pendaftaran;
    }

    /**
     * Mengirim ulang email verifikasi.
     */
    public function resendVerification(string $email): array
    {
        $mahasiswa = Mahasiswa::where('email', $email)->first();

        if (!$mahasiswa) {
            throw new \Exception('Email tidak ditemukan dalam sistem.');
        }

        // Cari pendaftaran pending terakhir
        $daftar = Daftar::where('email', $email)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$daftar) {
            throw new \Exception('Tidak ditemukan pendaftaran yang menunggu verifikasi.');
        }

        $this->sendVerificationEmail($mahasiswa, $daftar);

        return [
            'daftar_id' => $daftar->id,
            'email'     => $email
        ];
    }

    /**
     * Kirim email verifikasi dengan signed URL yang expire 5 menit.
     */
    private function sendVerificationEmail(Mahasiswa $mahasiswa, Daftar $daftar): void
    {
        $verificationUrl = URL::temporarySignedRoute(
            'mahasiswa.verifikasi.email',   // nama route
            now()->addMinutes(5),            // expire time
            [
                'mahasiswa_id' => $mahasiswa->id,
                'daftar_id'    => $daftar->id,
            ]
        );

        Mail::to($mahasiswa->email)->queue(
            new VerifikasiEmailMail($verificationUrl, $mahasiswa->name)
        );
    }
}

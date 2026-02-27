<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class NilaiEptImport implements ToCollection, WithHeadingRow
{
    public array $hasil = [];

    /**
     * Proses setiap baris Excel.
     * Header Excel harus berisi: nama, nim, nilai
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            // Ambil data dari kolom Excel (case-insensitive karena WithHeadingRow)
            $nimExcel  = trim((string) ($row['nim']   ?? $row['NIM']   ?? ''));
            $namaExcel = trim((string) ($row['nama']  ?? $row['Nama']  ?? $row['name'] ?? ''));
            $nilai     = (int) ($row['nilai'] ?? $row['Nilai'] ?? $row['score'] ?? 0);

            if (empty($nimExcel)) {
                continue; // Lewati baris kosong
            }

            // Cari mahasiswa berdasarkan NIM
            $mahasiswa = Mahasiswa::where('nim', $nimExcel)->first();

            if ($mahasiswa) {
                // ✅ Cocok: update score di database
                $mahasiswa->update(['score' => $nilai]);

                $this->hasil[] = [
                    'nim'    => $nimExcel,
                    'nama'   => $mahasiswa->name,
                    'nilai'  => $nilai,
                    'status' => 'berhasil',
                ];
            } else {
                // ❌ Tidak cocok: NIM dari Excel tidak ada di database
                $this->hasil[] = [
                    'nim'    => $nimExcel,
                    'nama'   => $namaExcel,
                    'nilai'  => $nilai,
                    'status' => 'tidak_ditemukan',
                ];
            }
        }
    }
}

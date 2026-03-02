<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;
use Carbon\Carbon;

/**
 * NilaiEptImport
 *
 * Kolom Excel yang didukung (sesuai sertifikat mahasiswa/dokumen):
 * ─────────────────────────────────────────────────────────────────
 * | Kolom Excel                       | Field DB            |
 * |-----------------------------------|---------------------|
 * | name / nama                       | name (read-only)    |
 * | RegNumber / Barcode / nim         | nim  (key pencarian)|
 * | testDate / test_date              | test_date           |
 * | Listening / Listening Comprehension| score_listening    |
 * | structure and written expression  | score_structure     |
 * | reading / Reading Comprehension   | score_reading       |
 * | Total / Total Score               | score               |
 * ─────────────────────────────────────────────────────────────────
 *
 * Catatan: WithHeadingRow mengubah header Excel menjadi:
 *   - huruf kecil semua
 *   - spasi → underscore
 *   - karakter non-alfanumerik dihapus/diubah
 * Misal: "structure and written expression" → "structure_and_written_expression"
 *        "Listening Comprehension"          → "listening_comprehension"
 *        "RegNumber"                        → "regnumber"
 */
class NilaiEptImport implements ToCollection, WithHeadingRow
{
    public array $hasil = [];

    /**
     * Ambil nilai dari $row array berdasarkan daftar kandidat key.
     * Pencocokan tidak sensitif huruf besar/kecil dan mengabaikan
     * karakter non-alfanumerik (spasi, underscore, dst).
     */
    private function getValue(array $row, array $candidates): string
    {
        // Buat indeks key yang sudah dinormalisasi → key asli
        $normalizedIndex = [];
        foreach (array_keys($row) as $key) {
            $norm = strtolower(preg_replace('/[^a-z0-9]/i', '', $key));
            $normalizedIndex[$norm] = $key;
        }

        foreach ($candidates as $candidate) {
            $normCandidate = strtolower(preg_replace('/[^a-z0-9]/i', '', $candidate));
            if (isset($normalizedIndex[$normCandidate])) {
                $realKey = $normalizedIndex[$normCandidate];
                return trim((string) ($row[$realKey] ?? ''));
            }
        }

        return '';
    }

    public function collection(Collection $rows): void
    {
        foreach ($rows as $rowCollection) {
            // ToCollection mengembalikan Collection per baris, konversi ke array dulu
            $row = $rowCollection->toArray();

            // ── Nama (KUNCI UTAMA PENCARIAN) ──────────────────────────
            // Excel: kolom "name" → dicocokkan ke field "name" di DB
            $nama = $this->getValue($row, [
                'name', 'nama', 'full_name', 'mahasiswa',
            ]);

            // Lewati baris tanpa nama
            if (empty($nama)) {
                continue;
            }

            // ── RegNumber / Barcode (hanya referensi, tidak untuk lookup) ─
            // Nilainya berbeda dengan NIM di database
            $refNumber = $this->getValue($row, [
                'RegNumber', 'regnumber',
                'Barcode',   'barcode',
                'nim',       'NIM',
                'registration_number',
            ]);

            // ── Tanggal Ujian ─────────────────────────────────────────
            // Excel: "testDate"
            // WithHeadingRow → "testdate"
            $testDate = $this->getValue($row, [
                'testDate', 'testdate', 'test_date', 'date', 'tanggal_ujian',
            ]);

            // ── Listening ─────────────────────────────────────────────
            // Excel: "Listening"
            // WithHeadingRow → "listening"
            $listening = (int) $this->getValue($row, [
                'Listening', 'listening',
                'Listening Comprehension', 'listening_comprehension',
                'score_listening',
            ]);

            // ── Structure and Written Expression ──────────────────────
            // Excel: "structure and written expression"
            // WithHeadingRow → "structure_and_written_expression"
            $structure = (int) $this->getValue($row, [
                'structure and written expression',
                'structure_and_written_expression',
                'structureandwrittenexpression',
                'Structure', 'structure',
                'score_structure',
            ]);

            // ── Reading ───────────────────────────────────────────────
            // Excel: "reading"
            // WithHeadingRow → "reading"
            $reading = (int) $this->getValue($row, [
                'reading',
                'Reading Comprehension', 'reading_comprehension',
                'score_reading',
            ]);

            // ── Total Score ───────────────────────────────────────────
            // Excel: "Total"
            // WithHeadingRow → "total"
            $total = (int) $this->getValue($row, [
                'Total', 'total',
                'Total Score', 'total_score',
                'score', 'nilai',
            ]);

            // ── Parse tanggal ─────────────────────────────────────────
            $parsedTestDate = null;
            if (!empty($testDate)) {
                try {
                    $parsedTestDate = Carbon::parse($testDate)->format('Y-m-d');
                } catch (\Exception $e) {
                    $parsedTestDate = null;
                }
            }

            // ── Cari mahasiswa berdasarkan NAMA ───────────────────────
            // Karena RegNumber/Barcode di Excel ≠ NIM di database,
            // kita cocokkan lewat nama mahasiswa (case-insensitive).
            $mahasiswa = Mahasiswa::whereRaw('LOWER(name) = ?', [strtolower(trim($nama))])->first();

            // Fallback: partial match (toleransi spasi/typo kecil)
            if (!$mahasiswa) {
                $mahasiswa = Mahasiswa::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower(trim($nama)) . '%'])->first();
            }

            if ($mahasiswa) {
                // ✅ Cocok: update nilai ke database
                $dataUpdate = [];
                if ($total      > 0) $dataUpdate['score']           = $total;
                if ($listening  > 0) $dataUpdate['score_listening'] = $listening;
                if ($structure  > 0) $dataUpdate['score_structure'] = $structure;
                if ($reading    > 0) $dataUpdate['score_reading']   = $reading;
                if ($parsedTestDate) $dataUpdate['test_date']       = $parsedTestDate;

                if (!empty($dataUpdate)) {
                    $mahasiswa->update($dataUpdate);
                }

                $this->hasil[] = [
                    'nim'       => $mahasiswa->nim,  // NIM dari database
                    'nama'      => $mahasiswa->name,
                    'listening' => $listening,
                    'structure' => $structure,
                    'reading'   => $reading,
                    'total'     => $total,
                    'test_date' => $parsedTestDate,
                    'status'    => 'berhasil',
                ];
            } else {
                // ❌ Nama tidak ditemukan di database
                $this->hasil[] = [
                    'nim'       => $refNumber,  // tampilkan RegNumber/Barcode dari Excel
                    'nama'      => $nama,
                    'listening' => $listening,
                    'structure' => $structure,
                    'reading'   => $reading,
                    'total'     => $total,
                    'test_date' => $parsedTestDate,
                    'status'    => 'tidak_ditemukan',
                ];
            }
        }
    }
}

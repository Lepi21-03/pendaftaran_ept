<?php

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\Daftar;
use Barryvdh\DomPDF\Facade\Pdf;

class DokumenService
{
    /**
     * Mengambil data Mahasiswa dan Pendaftaran terakhir yang berstatus success.
     */
    public function getDokumenData(int $mahasiswaId): array
    {
        $mahasiswa = Mahasiswa::find($mahasiswaId);
        
        $pendaftaran = Daftar::where('nim', $mahasiswa->nim)
            ->where('status', 'success')
            ->with(['ujian', 'kartuUjian'])
            ->latest()
            ->first();

        return [
            'mahasiswa'   => $mahasiswa,
            'pendaftaran' => $pendaftaran,
        ];
    }

    /**
     * Men-generate output PDF Kartu Ujian beserta nama file-nya.
     */
    public function generateKartuUjianPdf(int $mahasiswaId): array
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        $pendaftaran = Daftar::where('nim', $mahasiswa->nim)
            ->where('status', 'success')
            ->with(['ujian', 'kartuUjian'])
            ->latest()
            ->first();

        if (!$pendaftaran) {
            throw new \Exception('Kartu ujian belum tersedia. Pastikan pembayaran sudah diverifikasi.');
        }

        // Generate QR code and convert to base64 for DomPDF compatibility
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode(url('/'));
        $qrBase64 = '';
        try {
            $qrContent = file_get_contents($qrUrl);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
        } catch (\Exception $e) {
            // Fallback to URL
            $qrBase64 = $qrUrl;
        }

        $pdf = Pdf::loadView('mahasiswa.dokumen.kartu-ujian-pdf', [
            'record' => $pendaftaran,
            'qrCode' => $qrBase64
        ])->setPaper('a4', 'portrait');

        $namaClean = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $mahasiswa->name);
        $namaFile = 'KartuUjian-EPT-' . $namaClean . '.pdf';

        return [
            'pdf_output' => $pdf->output(),
            'nama_file'  => $namaFile,
        ];
    }

    /**
     * Men-generate output PDF Sertifikat beserta nama file-nya.
     */
    public function generateSertifikatPdf(int $mahasiswaId): array
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswaId);

        if (!$mahasiswa->score || $mahasiswa->score <= 0) {
            throw new \Exception('Sertifikat belum tersedia. Tunggu Admin menginput skor EPT Anda.');
        }

        $pdf = Pdf::loadView('mahasiswa.dokumen.sertifikat-pdf', ['mahasiswa' => $mahasiswa])
            ->setPaper('a6', 'portrait');

        $namaClean = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $mahasiswa->name);
        $namaFile = 'Sertifikat-EPT-' . $namaClean . '.pdf';

        return [
            'pdf_output' => $pdf->output(),
            'nama_file'  => $namaFile,
        ];
    }
}

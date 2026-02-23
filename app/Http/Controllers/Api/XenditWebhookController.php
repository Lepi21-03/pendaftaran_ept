<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request, \App\Services\PembayaranService $pembayaranService)
    {
        // Ambil callback token dari header request
        $webhookToken = $request->header('x-callback-token');
        
        Log::info('Webhook Incoming. Token received: ' . $webhookToken);
        
        // Verifikasi token dengan yang ada di .env
        $myToken = env('XENDIT_CALLBACK_TOKEN');

        if ($webhookToken !== $myToken) {
            return response()->json(['message' => 'Invalid token'], 403);
        }

        // Ambil data pembayaran
        $data = $request->all();
        
        // Log data untuk debugging (opsional, bisa dihapus nanti)
        Log::info('Xendit Webhook Received:', $data);

        // Contoh external_id dari createInvoice: 'EPT-DAFTAR-{id}-{time}'
        $externalId = $data['external_id'] ?? '';
        $status = $data['status'] ?? '';

        if ($status === 'PAID') {
            // Memecah string external_id untuk mendapatkan ID pendaftaran aslinya
            $parts = explode('-', $externalId);
            if (count($parts) >= 3 && $parts[0] === 'EPT' && $parts[1] === 'DAFTAR') {
                $daftarId = (int) $parts[2];

                try {
                    // Cek apakah belum di-generate (untuk menghindari error double webhook)
                    $daftar = \App\Models\Daftar::find($daftarId);
                    if ($daftar && $daftar->status === 'pending') {
                        // Eksekusi: Proses Bayar, Buat Kartu Ujian, dan Masukkan ke Tabel Mahasiswa
                        $pembayaranService->bayarDanGenerateKartu($daftarId);
                        Log::info("Pendaftaran dengan ID {$daftarId} berhasil dibayar dan menjadi Mahasiswa.");
                    }
                } catch (\Exception $e) {
                    Log::error("Error saat memproses webhook pendaftaran {$daftarId}: " . $e->getMessage());
                }
            }
        }

        return response()->json(['message' => 'Success'], 200);
    }
}

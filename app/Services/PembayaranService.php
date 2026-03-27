<?php

namespace App\Services;

use App\Models\Daftar;
use App\Models\Pembayaran;
use App\Models\KartuUjian;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

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

    public function createInvoiceForVerification(int $mahasiswa_id, int $daftar_id): array
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswa_id);
        $daftar = Daftar::findOrFail($daftar_id);

        if (!$mahasiswa->email_verified_at) {
            $mahasiswa->update(['email_verified_at' => now()]);
        }

        if ($daftar->status === 'success') {
            return ['status' => 'already_success', 'mahasiswa' => $mahasiswa];
        }

        $apiKey = config('services.xendit.api_key');
        if (empty($apiKey)) {
            throw new \Exception('Konfigurasi Xendit API Key belum diatur pada server.');
        }

        \Xendit\Configuration::setXenditKey($apiKey);

        $options = [];
        if (app()->environment('local') && file_exists(storage_path('app/cacert.pem'))) {
            $options['verify'] = storage_path('app/cacert.pem');
        }

        $guzzleClient = new Client($options);
        $apiInstance = new \Xendit\Invoice\InvoiceApi($guzzleClient);

        $externalId = 'EPT-DAFTAR-' . $daftar->id . '-' . time();
        $successUrl = route('mahasiswa.pembayaran.sukses', ['daftar_id' => $daftar->id]);
        $failureUrl = route('mahasiswa.ujian.index');

        $create_invoice_request = new \Xendit\Invoice\CreateInvoiceRequest([
            'external_id' => $externalId,
            'description' => 'Pembayaran Pendaftaran EPT - ' . $daftar->nim,
            'amount'      => 100000,
            'payer_email' => $daftar->email,
            'customer'    => [
                'given_names'   => $daftar->nama_lengkap,
                'email'         => $daftar->email,
                'mobile_number' => $daftar->no_telp,
            ],
            'success_redirect_url' => $successUrl,
            'failure_redirect_url' => $failureUrl,
        ]);

        $result = $apiInstance->createInvoice($create_invoice_request);

        $daftar->update(['xendit_invoice_id' => $result['id']]);

        return ['status' => 'redirect', 'url' => $result['invoice_url']];
    }

    public function verifyPembayaranSukses(int $daftarId): array
    {
        $daftar = Daftar::findOrFail($daftarId);

        if ($daftar->status === 'success') {
            $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
            return ['status' => 'already_success', 'mahasiswa' => $mahasiswa];
        }

        \Xendit\Configuration::setXenditKey(config('services.xendit.api_key'));

        $options = [];
        if (app()->environment('local') && file_exists(storage_path('app/cacert.pem'))) {
            $options['verify'] = storage_path('app/cacert.pem');
        }

        $guzzleClient = new Client($options);
        $apiInstance = new \Xendit\Invoice\InvoiceApi($guzzleClient);
        $invoice     = $apiInstance->getInvoiceById($daftar->xendit_invoice_id);

        if ($invoice['status'] === 'PAID' || $invoice['status'] === 'SETTLED') {
            $this->bayarDanGenerateKartu($daftarId);
            $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
            return ['status' => 'success', 'mahasiswa' => $mahasiswa];
        }

        throw new \Exception('Pembayaran belum terverifikasi. Silakan coba beberapa saat lagi.');
    }

    public function handleWebhook(string $webhookToken, array $data): void
    {
        Log::info('Webhook Incoming. Token received: ' . $webhookToken);
        $myToken = config('services.xendit.callback_token');

        if ($webhookToken !== $myToken) {
            throw new \Exception('Invalid token', 403);
        }

        Log::info('Xendit Webhook Received:', $data);

        $externalId = $data['external_id'] ?? '';
        $status = $data['status'] ?? '';

        if ($status === 'PAID') {
            $parts = explode('-', $externalId);
            if (count($parts) >= 3 && $parts[0] === 'EPT' && $parts[1] === 'DAFTAR') {
                $daftarId = (int) $parts[2];
                $daftar = Daftar::find($daftarId);
                if ($daftar && $daftar->status === 'pending') {
                    $this->bayarDanGenerateKartu($daftarId);
                    Log::info("Pendaftaran dengan ID {$daftarId} berhasil dibayar dan menjadi Mahasiswa.");
                }
            }
        }
    }

    public function cekStatus(int $daftarId): string
    {
        $daftar = Daftar::find($daftarId);
        if (!$daftar) {
            return 'not_found';
        }
        return $daftar->status;
    }
}
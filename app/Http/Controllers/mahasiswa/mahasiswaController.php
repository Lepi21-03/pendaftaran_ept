<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\Daftar;
use App\Models\Prodi;
use App\Models\Mahasiswa;
use App\Services\PendaftaranService;
use App\Services\PembayaranService;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;


class MahasiswaController extends Controller
{
    public function ujian()
    {
        $ujian = Ujian::with('pengawas')->where('status', 'open')->get();
        return view('mahasiswa.ujian.index', compact('ujian'));
    }

    public function login()
    {
        return view('mahasiswa.login.index');
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required', // Ini adalah NIM dari form
        ]);

        $mahasiswa = Mahasiswa::where('email', $credentials['email'])
            ->where('nim', $credentials['password'])
            ->first();

        if ($mahasiswa) {
            Auth::guard('mahasiswa')->login($mahasiswa);

            // Regenerate session setelah login berhasil (Keamanan)
            $request->session()->regenerate();

            return redirect()->intended(route('mahasiswa.ujian.index'))
                ->with('success', 'Selamat datang kembali, ' . $mahasiswa->name);
        }

        return back()->withErrors([
            'email' => 'Email atau NIM tidak sesuai dengan data kami.',
        ])->onlyInput('email');
    }


    public function dokumen()
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();
        return view('mahasiswa.dokumen.index', compact('mahasiswa'));
    }

    public function daftar(Request $request)
    {
        $id = $request->query('ujian_id');
        $ujian = Ujian::findOrFail($id);
        $prodis = Prodi::all();
        return view('mahasiswa.daftar.index', compact('ujian', 'prodis'));
    }

    public function store(Request $request, PendaftaranService $service)
    {
        $validated = $request->validate([
            'ujian_id'      => 'required|exists:ujians,id',
            'nim'           => 'required',
            'nama_lengkap'  => 'required',
            'bod'           => 'required|date',
            'prodi'         => 'required',
            'no_telp'       => 'required',
            'email'         => 'required|email',
        ]);

        try {
            $pendaftaran = $service->daftar($validated);

            $apiKey = env('XENDIT_API_KEY');
            if (empty($apiKey)) {
                return back()->withInput()->withErrors('Konfigurasi Xendit API Key belum diatur pada server.');
            }

            \Xendit\Configuration::setXenditKey($apiKey);

            // ✅ Gunakan cacert.pem lokal jika berjalan di lingkungan lokal untuk menghindari cURL error 60
            $options = [];
            if (app()->environment('local') && file_exists(storage_path('app/cacert.pem'))) {
                $options['verify'] = storage_path('app/cacert.pem');
            }

            $guzzleClient = new Client($options);
            $apiInstance = new \Xendit\Invoice\InvoiceApi($guzzleClient);

            $externalId = 'EPT-DAFTAR-' . $pendaftaran->id . '-' . time();

            // ✅ URL redirect menggunakan route() langsung — APP_URL dari .env sudah dihandle Laravel
            $successUrl = route('mahasiswa.pembayaran.sukses', ['daftar_id' => $pendaftaran->id]);
            $failureUrl = route('mahasiswa.ujian.index');

            $create_invoice_request = new \Xendit\Invoice\CreateInvoiceRequest([
                'external_id' => $externalId,
                'description' => 'Pembayaran Pendaftaran EPT - ' . $pendaftaran->nim,
                'amount'      => 100000,
                'payer_email' => $pendaftaran->email,
                'customer'    => [
                    'given_names'   => $pendaftaran->nama_lengkap,
                    'email'         => $pendaftaran->email,
                    'mobile_number' => $pendaftaran->no_telp,
                ],
                'success_redirect_url' => $successUrl,
                'failure_redirect_url' => $failureUrl,
            ]);

            $result = $apiInstance->createInvoice($create_invoice_request);

            // ✅ Simpan xendit_invoice_id agar bisa diverifikasi nanti
            $pendaftaran->update([
                'xendit_invoice_id' => $result['id'],
            ]);

            return redirect($result['invoice_url']);

        } catch (\Xendit\XenditSdkException $e) {
            return back()->withInput()->withErrors('Xendit Error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * ✅ Dipanggil otomatis oleh Xendit saat user selesai bayar.
     * Verifikasi status invoice langsung ke API Xendit, lalu proses data mahasiswa.
     */
    public function pembayaranSukses(Request $request, PembayaranService $pembayaranService)
    {
        $daftarId = $request->query('daftar_id');

        if (!$daftarId) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Parameter tidak valid.');
        }

        $daftar = Daftar::find($daftarId);

        if (!$daftar) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Data pendaftaran tidak ditemukan.');
        }

        // Jika sudah diproses sebelumnya, langsung tampilkan sukses
        if ($daftar->status === 'success') {
            // Auto Login Mahasiswa (Cek DB)
            $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
            if ($mahasiswa) {
                Auth::guard('mahasiswa')->login($mahasiswa);
            }
            
            return redirect()->route('mahasiswa.ujian.index')
                ->with('success', '✅ Pembayaran berhasil! Data kamu sudah tercatat.');
        }

        try {
            // ✅ Verifikasi langsung ke Xendit API: cek status invoice
            \Xendit\Configuration::setXenditKey(env('XENDIT_API_KEY'));

            // ✅ Gunakan cacert.pem lokal jika berjalan di lingkungan lokal
            $options = [];
            if (app()->environment('local') && file_exists(storage_path('app/cacert.pem'))) {
                $options['verify'] = storage_path('app/cacert.pem');
            }

            $guzzleClient = new Client($options);
            $apiInstance = new \Xendit\Invoice\InvoiceApi($guzzleClient);
            $invoice     = $apiInstance->getInvoiceById($daftar->xendit_invoice_id);


            if ($invoice['status'] === 'PAID' || $invoice['status'] === 'SETTLED') {
                // ✅ Proses: simpan pembayaran, buat kartu ujian, dan masukkan ke tabel mahasiswas
                // Logika pemindahan data pendaftaran -> mahasiswa ada di dalam service ini
                $pembayaranService->bayarDanGenerateKartu($daftarId);

                // ✅ AUTO LOGIN: Hanya setelah data ada di DB dan tervalidasi PAID
                $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
                if ($mahasiswa) {
                    Auth::guard('mahasiswa')->login($mahasiswa);
                }

                return redirect()->route('mahasiswa.ujian.index')
                    ->with('success', '✅ Pembayaran berhasil! Data kamu sudah tercatat sebagai mahasiswa peserta EPT.');
            }

            // Invoice belum dibayar
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Pembayaran belum terverifikasi. Silakan coba beberapa saat lagi.');

        } catch (\Throwable $e) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Terjadi kesalahan saat verifikasi: ' . $e->getMessage());
        }
    }

    public function bayar($daftarId, PembayaranService $service)
    {
        try {
            $kartu = $service->bayarDanGenerateKartu($daftarId);

            return redirect()->route('mahasiswa.ujian.index')
                ->with('success', 'Pembayaran berhasil, Kartu Ujian Dibuat');
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }

   public function logout(Request $request)
    {
    Auth::guard('mahasiswa')->logout();

    // Hapus semua data di dalam session
    $request->session()->flush(); 

    // Hapus session file/record dan buat ID baru
    $request->session()->invalidate();

    // Buat CSRF token baru agar yang lama tidak bisa di-hijack
    $request->session()->regenerateToken();

    return redirect()->route('mahasiswa.ujian.index');
    }

}

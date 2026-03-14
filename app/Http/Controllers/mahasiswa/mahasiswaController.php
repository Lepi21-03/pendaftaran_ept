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
use App\Mail\VerifikasiEmailMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use GuzzleHttp\Client;
use Barryvdh\DomPDF\Facade\Pdf;


class MahasiswaController extends Controller
{
    // ================================================================
    // HALAMAN UJIAN
    // ================================================================

    public function ujian()
    {
        $ujian = Ujian::with('pengawas')
            ->where('status', 'open')
            ->orderBy('tanggal_ujian', 'desc')
            ->get();
            
        return view('mahasiswa.ujian.index', compact('ujian'));
    }

    // ================================================================
    // LOGIN (Email + Password)
    // ================================================================

    public function login()
    {
        return view('mahasiswa.login.index');
    }

    /**
     * Proses login menggunakan Email + Password.
     * Menggunakan Auth::guard('mahasiswa')->attempt() untuk verifikasi kredensial.
     * Password akan diverifikasi dengan Hash::check() secara otomatis oleh Laravel.
     */
    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        // Auth::attempt() secara otomatis melakukan:
        // 1. Cari user berdasarkan email
        // 2. Verifikasi password dengan Hash::check()
        // 3. Login user jika cocok
        if (Auth::guard('mahasiswa')->attempt($credentials)) {
            // Regenerate session untuk keamanan (mencegah session fixation attack)
            $request->session()->regenerate();

            return redirect()->intended(route('mahasiswa.ujian.index'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    // ================================================================
    // DOKUMEN (Kartu Ujian & Sertifikat) — TIDAK DIUBAH
    // ================================================================

    public function dokumen()
    {
        $authenticatedUser = Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Re-fetch mahasiswa dari database untuk memastikan data (terutama score) paling update
        $mahasiswa = Mahasiswa::find($authenticatedUser->id);

        // Ambil pendaftaran terakhir yang sukses untuk menampilkan kartu ujian
        $pendaftaran = Daftar::where('nim', $mahasiswa->nim)
            ->where('status', 'success')
            ->with(['ujian', 'kartuUjian'])
            ->latest()
            ->first();

        return view('mahasiswa.dokumen.index', compact('mahasiswa', 'pendaftaran'));
    }

    // ================================================================
    // PENDAFTARAN (REGISTRASI + EMAIL VERIFIKASI)
    // ================================================================

    public function daftar(Request $request)
    {
        $id = $request->query('ujian_id');
        $ujian = Ujian::findOrFail($id);
        $prodis = Prodi::all();
        return view('mahasiswa.daftar.index', compact('ujian', 'prodis'));
    }

    /**
     * Proses registrasi:
     * 1. Validasi data + password
     * 2. Simpan pendaftaran via PendaftaranService
     * 3. Buat/update data Mahasiswa dengan password (hashed otomatis via cast)
     * 4. Kirim email verifikasi (signed URL, expire 5 menit)
     * 5. Redirect ke halaman "Cek Email Anda"
     *
     * PENTING: User TIDAK langsung login. User HARUS verifikasi email dulu,
     * lalu bayar, baru auto login.
     */
    public function store(Request $request, PendaftaranService $service)
    {
        $validated = $request->validate([
            'ujian_id'              => 'required|exists:ujians,id',
            'nim'                   => 'required',
            'nama_lengkap'          => 'required',
            'tempat_lahir'          => 'required',
            'bod'                   => 'required|date',
            'prodi'                 => 'required',
            'no_telp'               => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
        ]);

        try {
            // 1. Simpan pendaftaran (via PendaftaranService yang sudah ada)
            $pendaftaran = $service->daftar($validated);

            // 2. Buat/update Mahasiswa dengan password
            //    Cast 'hashed' di model akan otomatis hash password
            $mahasiswa = Mahasiswa::updateOrCreate(
                ['nim' => $validated['nim']],
                [
                    'name'     => $validated['nama_lengkap'],
                    'prodi'    => $validated['prodi'],
                    'email'    => $validated['email'],
                    'phone'    => $validated['no_telp'],
                    'password' => $validated['password'], // Otomatis di-hash oleh cast
                ]
            );

            // 3. Kirim email verifikasi dengan signed URL (expire 5 menit)
            $this->sendVerificationEmail($mahasiswa, $pendaftaran);

            // 4. Redirect ke halaman "Cek Email Anda"
            return redirect()->route('mahasiswa.verifikasi.cek-email')
                ->with('verification_email', $validated['email'])
                ->with('verification_daftar_id', $pendaftaran->id);

        } catch (\Throwable $e) {
            return back()->withInput()->withErrors($e->getMessage());
        }
    }

    // ================================================================
    // EMAIL VERIFIKASI
    // ================================================================

    /**
     * Halaman "Cek Email Anda" — ditampilkan setelah registrasi.
     * Menampilkan countdown timer 5 menit dan tombol resend.
     */
    public function cekEmail()
    {
        return view('mahasiswa.verifikasi.cek-email');
    }

    /**
     * Handle klik link verifikasi dari email (signed URL).
     * 
     * Flow:
     * 1. Signed URL divalidasi oleh middleware 'signed' (otomatis)
     * 2. Set email_verified_at pada mahasiswa
     * 3. Buat invoice Xendit → redirect ke Xendit (TANPA LOGIN)
     * 4. Setelah bayar, Xendit redirect ke pembayaranSukses()
     * 5. Di pembayaranSukses() → verifikasi → AUTO LOGIN
     */
    public function verifikasiEmail(Request $request, $mahasiswa_id, $daftar_id)
    {
        $mahasiswa = Mahasiswa::findOrFail($mahasiswa_id);
        $daftar = Daftar::findOrFail($daftar_id);

        // Set email sebagai terverifikasi
        if (!$mahasiswa->email_verified_at) {
            $mahasiswa->update(['email_verified_at' => now()]);
        }

        // Jika pendaftaran sudah success (sudah bayar sebelumnya)
        if ($daftar->status === 'success') {
            // Auto login karena sudah pernah bayar
            Auth::guard('mahasiswa')->login($mahasiswa);
            $request->session()->regenerate();

            return redirect()->route('mahasiswa.ujian.index')
                ->with('success', '✅ Email sudah terverifikasi dan pembayaran sudah tercatat!');
        }

        // Buat invoice Xendit dan redirect ke halaman Xendit (TANPA LOGIN)
        try {
            $apiKey = env('XENDIT_API_KEY');
            if (empty($apiKey)) {
                return redirect()->route('mahasiswa.ujian.index')
                    ->withErrors('Konfigurasi Xendit API Key belum diatur pada server.');
            }

            \Xendit\Configuration::setXenditKey($apiKey);

            // Gunakan cacert.pem lokal jika berjalan di lingkungan lokal
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

            // Simpan xendit_invoice_id
            $daftar->update([
                'xendit_invoice_id' => $result['id'],
            ]);

            // Redirect ke Xendit (USER BELUM LOGIN)
            return redirect($result['invoice_url']);

        } catch (\Xendit\XenditSdkException $e) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Xendit Error: ' . $e->getMessage());
        } catch (\Throwable $e) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Kirim ulang email verifikasi.
     * Token/link lama otomatis tidak berlaku karena signed URL baru dibuat.
     */
    public function resendVerifikasi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $mahasiswa = Mahasiswa::where('email', $request->email)->first();

        if (!$mahasiswa) {
            return back()->withErrors('Email tidak ditemukan dalam sistem.');
        }

        // Cari pendaftaran pending terakhir
        $daftar = Daftar::where('email', $request->email)
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$daftar) {
            return back()->withErrors('Tidak ditemukan pendaftaran yang menunggu verifikasi.');
        }

        // Kirim email verifikasi baru (link lama otomatis expired karena signed URL baru)
        $this->sendVerificationEmail($mahasiswa, $daftar);

        return back()
            ->with('success', 'Email verifikasi baru telah dikirim! Silakan cek inbox Anda.')
            ->with('verification_email', $request->email)
            ->with('verification_daftar_id', $daftar->id);
    }

    /**
     * API: Cek status pembayaran pendaftaran (dipanggil via AJAX polling).
     * Halaman cek-email memanggil ini setiap 3 detik untuk mendeteksi
     * apakah pembayaran sudah selesai di tab lain.
     * Mengembalikan JSON { status: 'pending' | 'success' }
     */
    public function cekStatusPembayaran($daftar_id)
    {
        $daftar = Daftar::find($daftar_id);

        if (!$daftar) {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json(['status' => $daftar->status]);
    }

    // ================================================================
    // PEMBAYARAN XENDIT
    // ================================================================

    /**
     * Dipanggil setelah user selesai bayar di Xendit (redirect dari Xendit).
     * Verifikasi status invoice langsung ke API Xendit.
     * Jika PAID → proses pembayaran → AUTO LOGIN → redirect halaman utama.
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

        // Jika sudah diproses sebelumnya, langsung auto login
        if ($daftar->status === 'success') {
            $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
            if ($mahasiswa) {
                Auth::guard('mahasiswa')->login($mahasiswa);
                $request->session()->regenerate();
            }

            // Tampilkan halaman "tutup tab" inline — tab cek-email sudah mendeteksi via polling
            return $this->selfClosingResponse();
        }

        try {
            // Verifikasi langsung ke Xendit API: cek status invoice
            \Xendit\Configuration::setXenditKey(env('XENDIT_API_KEY'));

            $options = [];
            if (app()->environment('local') && file_exists(storage_path('app/cacert.pem'))) {
                $options['verify'] = storage_path('app/cacert.pem');
            }

            $guzzleClient = new Client($options);
            $apiInstance = new \Xendit\Invoice\InvoiceApi($guzzleClient);
            $invoice     = $apiInstance->getInvoiceById($daftar->xendit_invoice_id);

            if ($invoice['status'] === 'PAID' || $invoice['status'] === 'SETTLED') {
                // Proses: simpan pembayaran, buat kartu ujian, update tabel mahasiswas
                $pembayaranService->bayarDanGenerateKartu($daftarId);

                // AUTO LOGIN — hanya setelah pembayaran berhasil diverifikasi
                $mahasiswa = Mahasiswa::where('nim', $daftar->nim)->first();
                if ($mahasiswa) {
                    Auth::guard('mahasiswa')->login($mahasiswa);
                    $request->session()->regenerate();
                }

                // Tampilkan halaman "tutup tab" — tab cek-email sudah mendeteksi via polling
                return view('mahasiswa.pembayaran.sukses-tutup');
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

    // ================================================================
    // DOWNLOAD PDF — TIDAK DIUBAH
    // ================================================================

    /**
     * Download Kartu Ujian sebagai PDF.
     */
    public function downloadKartuUjian()
    {
        $authenticatedUser = Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = Mahasiswa::findOrFail($authenticatedUser->id);

        $pendaftaran = Daftar::where('nim', $mahasiswa->nim)
            ->where('status', 'success')
            ->with(['ujian', 'kartuUjian'])
            ->latest()
            ->first();

        if (!$pendaftaran) {
            return redirect()->route('mahasiswa.dokumen')
                ->with('error', 'Kartu ujian belum tersedia. Pastikan pembayaran sudah diverifikasi.');
        }

        // Generate QR code and convert to base64 for DomPDF compatibility
        $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode(url('/'));
        $qrBase64 = '';
        try {
            $qrContent = file_get_contents($qrUrl);
            $qrBase64 = 'data:image/png;base64,' . base64_encode($qrContent);
        } catch (\Exception $e) {
            // Fallback to URL if file_get_contents fails, but usually this is why it won't show in PDF
            $qrBase64 = $qrUrl;
        }

        $pdf = Pdf::loadView('mahasiswa.dokumen.kartu-ujian-pdf', [
            'record' => $pendaftaran,
            'qrCode' => $qrBase64
        ])
            ->setPaper('a4', 'portrait');

        $namaClean = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $mahasiswa->name);
        $namaFile = 'KartuUjian-EPT-' . $namaClean . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ]);
    }

    /**
     * Download Sertifikat sebagai PDF.
     */
    public function downloadSertifikat()
    {
        $authenticatedUser = Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        $mahasiswa = Mahasiswa::findOrFail($authenticatedUser->id);

        if (!$mahasiswa->score || $mahasiswa->score <= 0) {
            return redirect()->route('mahasiswa.dokumen')
                ->with('error', 'Sertifikat belum tersedia. Tunggu Admin menginput skor EPT Anda.');
        }

        $pdf = Pdf::loadView('mahasiswa.dokumen.sertifikat-pdf', ['mahasiswa' => $mahasiswa])
            ->setPaper('a6', 'portrait');

        $namaClean = str_replace([' ', '/', '\\', ':', '*', '?', '"', '<', '>', '|'], '-', $mahasiswa->name);
        $namaFile = 'Sertifikat-EPT-' . $namaClean . '.pdf';

        return response($pdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $namaFile . '"',
        ]);
    }

    // ================================================================
    // LOGOUT
    // ================================================================

    /**
     * Logout mahasiswa.
     * Menghapus session, invalidate, dan regenerate CSRF token.
     * Setelah logout, user harus login kembali dengan Email + Password.
     */
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

    // ================================================================
    // PRIVATE HELPER
    // ================================================================

    /**
     * Kirim email verifikasi dengan signed URL yang expire 5 menit.
     *
     * Signed URL menggunakan Laravel URL::temporarySignedRoute() yang secara otomatis:
     * - Menambahkan signature hash ke URL
     * - Menambahkan parameter 'expires' (timestamp)
     * - Middleware 'signed' akan menolak URL yang expired atau dimodifikasi
     */
    private function sendVerificationEmail(Mahasiswa $mahasiswa, Daftar $daftar): void
    {
        // Buat signed URL yang expire dalam 5 menit
        $verificationUrl = URL::temporarySignedRoute(
            'mahasiswa.verifikasi.email',   // nama route
            now()->addMinutes(5),            // expire time
            [
                'mahasiswa_id' => $mahasiswa->id,
                'daftar_id'    => $daftar->id,
            ]
        );

        // Kirim email
        Mail::to($mahasiswa->email)->send(
            new VerifikasiEmailMail($verificationUrl, $mahasiswa->name)
        );
    }

    /**
     * Response inline HTML yang mencoba menutup tab browser secara otomatis.
     * Digunakan setelah pembayaran Xendit berhasil agar tab Xendit tertutup
     * dan user kembali ke tab cek-email yang sudah mendeteksi sukses via polling.
     */
    private function selfClosingResponse()
    {
        $html = '<!DOCTYPE html><html><head><title>Pembayaran Berhasil</title>'
            . '<script src="https://cdn.tailwindcss.com"></script>'
            . '<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet"/>'
            . '<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200"/>'
            . '<style>body{font-family:"Plus Jakarta Sans",sans-serif}</style></head>'
            . '<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">'
            . '<div class="w-full max-w-md bg-white rounded-xl shadow-lg border border-slate-200 p-8 text-center">'
            . '<div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-5">'
            . '<span class="material-symbols-outlined text-green-500 text-4xl">check_circle</span></div>'
            . '<h1 class="text-2xl font-bold text-slate-900 mb-2">Pembayaran Berhasil! ✅</h1>'
            . '<p class="text-slate-500 text-sm mb-6">Tab ini akan tertutup otomatis. Silakan kembali ke tab sebelumnya.</p>'
            . '<p id="h" class="hidden text-slate-400 text-xs">Jika tab tidak tertutup, Anda bisa menutupnya secara manual.</p></div>'
            . '<script>setTimeout(function(){window.close();setTimeout(function(){document.getElementById("h").classList.remove("hidden")},500)},1500)</script>'
            . '</body></html>';

        return response($html);
    }
}

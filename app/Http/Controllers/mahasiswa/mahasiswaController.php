<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PendaftaranService;
use App\Services\PembayaranService;
use App\Services\LoginService;
use App\Services\UjianService;
use App\Services\DokumenService;
use App\Models\Ujian;
use App\Models\Prodi;

class MahasiswaController extends Controller
{
    protected $pendaftaranService;
    protected $pembayaranService;
    protected $loginService;
    protected $ujianService;
    protected $dokumenService;

    public function __construct(
        PendaftaranService $pendaftaranService,
        PembayaranService $pembayaranService,
        LoginService $loginService,
        UjianService $ujianService,
        DokumenService $dokumenService
    ) {
        $this->pendaftaranService = $pendaftaranService;
        $this->pembayaranService  = $pembayaranService;
        $this->loginService       = $loginService;
        $this->ujianService       = $ujianService;
        $this->dokumenService     = $dokumenService;
    }

    // ================================================================
    // HALAMAN UJIAN
    // ================================================================

    public function ujian()
    {
        $ujian = $this->ujianService->getOpenUjian();
        return view('mahasiswa.ujian.index', compact('ujian'));
    }

    // ================================================================
    // LOGIN (Email + Password)
    // ================================================================

    public function login()
    {
        return view('mahasiswa.login.index');
    }

    public function loginStore(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($this->loginService->loginWithPassword($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('mahasiswa.ujian.index'))
                ->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ])->onlyInput('email');
    }

    // ================================================================
    // DOKUMEN (Kartu Ujian & Sertifikat)
    // ================================================================

    public function dokumen()
    {
        $authenticatedUser = \Illuminate\Support\Facades\Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $data = $this->dokumenService->getDokumenData($authenticatedUser->id);

        return view('mahasiswa.dokumen.index', [
            'mahasiswa'   => $data['mahasiswa'],
            'pendaftaran' => $data['pendaftaran'],
        ]);
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

    public function store(Request $request)
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
            $pendaftaran = $this->pendaftaranService->daftarWithAccount($validated);

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

    public function cekEmail()
    {
        return view('mahasiswa.verifikasi.cek-email');
    }

    public function verifikasiEmail(Request $request, $mahasiswa_id, $daftar_id)
    {
        try {
            $result = $this->pembayaranService->createInvoiceForVerification($mahasiswa_id, $daftar_id);

            if ($result['status'] === 'already_success') {
                \Illuminate\Support\Facades\Auth::guard('mahasiswa')->login($result['mahasiswa']);
                $request->session()->regenerate();

                return redirect()->route('mahasiswa.ujian.index')
                    ->with('success', '✅ Email sudah terverifikasi dan pembayaran sudah tercatat!');
            }

            return redirect($result['url']);
        } catch (\Throwable $e) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors($e->getMessage());
        }
    }

    public function resendVerifikasi(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            $result = $this->pendaftaranService->resendVerification($request->email);

            return back()
                ->with('success', 'Email verifikasi baru telah dikirim! Silakan cek inbox Anda.')
                ->with('verification_email', $result['email'])
                ->with('verification_daftar_id', $result['daftar_id']);
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function cekStatusPembayaran($daftar_id)
    {
        $status = $this->pembayaranService->cekStatus($daftar_id);
        
        if ($status === 'not_found') {
            return response()->json(['status' => 'not_found']);
        }

        return response()->json(['status' => $status]);
    }

    // ================================================================
    // PEMBAYARAN XENDIT
    // ================================================================

    public function pembayaranSukses(Request $request)
    {
        $daftarId = $request->query('daftar_id');

        if (!$daftarId) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Parameter tidak valid.');
        }

        try {
            $result = $this->pembayaranService->verifyPembayaranSukses((int) $daftarId);

            if ($result['status'] === 'already_success') {
                \Illuminate\Support\Facades\Auth::guard('mahasiswa')->login($result['mahasiswa']);
                $request->session()->regenerate();
                return $this->selfClosingResponse();
            }

            if ($result['status'] === 'success') {
                \Illuminate\Support\Facades\Auth::guard('mahasiswa')->login($result['mahasiswa']);
                $request->session()->regenerate();
                return view('mahasiswa.pembayaran.sukses-tutup');
            }
        } catch (\Throwable $e) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors($e->getMessage());
        }
    }

    public function bayar($daftarId)
    {
        try {
            $this->pembayaranService->bayarDanGenerateKartu($daftarId);

            return redirect()->route('mahasiswa.ujian.index')
                ->with('success', 'Pembayaran berhasil, Kartu Ujian Dibuat');
        } catch (\Throwable $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    // ================================================================
    // DOWNLOAD PDF
    // ================================================================

    public function downloadKartuUjian()
    {
        $authenticatedUser = \Illuminate\Support\Facades\Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $data = $this->dokumenService->generateKartuUjianPdf($authenticatedUser->id);

            return response($data['pdf_output'], 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $data['nama_file'] . '"',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.dokumen')
                ->with('error', $e->getMessage());
        }
    }

    public function downloadSertifikat()
    {
        $authenticatedUser = \Illuminate\Support\Facades\Auth::guard('mahasiswa')->user();

        if (!$authenticatedUser) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        try {
            $data = $this->dokumenService->generateSertifikatPdf($authenticatedUser->id);

            return response($data['pdf_output'], 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $data['nama_file'] . '"',
            ]);
        } catch (\Exception $e) {
            return redirect()->route('mahasiswa.dokumen')
                ->with('error', $e->getMessage());
        }
    }

    // ================================================================
    // LOGOUT
    // ================================================================

    public function logout(Request $request)
    {
        $this->loginService->logout($request);
        return redirect()->route('mahasiswa.ujian.index');
    }

    // ================================================================
    // PRIVATE HELPER
    // ================================================================

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

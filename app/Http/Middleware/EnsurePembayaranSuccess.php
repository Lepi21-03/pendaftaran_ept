<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Daftar;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: EnsurePembayaranSuccess
 *
 * Fungsi: Mengecek apakah mahasiswa memiliki setidaknya satu pendaftaran
 * dengan status 'success' (pembayaran berhasil).
 * Jika belum → redirect dengan pesan error.
 */
class EnsurePembayaranSuccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek apakah ada pendaftaran dengan status success
        $hasPaid = Daftar::where('nim', $mahasiswa->nim)
            ->where('status', 'success')
            ->exists();

        if (!$hasPaid) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Anda belum menyelesaikan pembayaran. Silakan selesaikan pembayaran terlebih dahulu.');
        }

        return $next($request);
    }
}

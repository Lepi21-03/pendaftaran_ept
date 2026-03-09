<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware: EnsureEmailVerified
 *
 * Fungsi: Mengecek apakah mahasiswa yang login sudah memverifikasi email mereka.
 * Jika belum login → redirect ke halaman login.
 * Jika sudah login tapi email belum diverifikasi → redirect dengan pesan error.
 */
class EnsureEmailVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        $mahasiswa = Auth::guard('mahasiswa')->user();

        // Belum login
        if (!$mahasiswa) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Email belum diverifikasi
        if (!$mahasiswa->email_verified_at) {
            return redirect()->route('mahasiswa.ujian.index')
                ->withErrors('Email Anda belum diverifikasi. Silakan cek email Anda.');
        }

        return $next($request);
    }
}

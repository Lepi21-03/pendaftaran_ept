<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetController extends Controller
{
    /**
     * Menampilkan halaman form input email (Forgot Password).
     */
    public function showLinkRequestForm()
    {
        return view('mahasiswa.login.forgot-password');
    }

    /**
     * Menangani pengiriman link reset password ke email.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Menggunakan broker 'mahasiswas' yang sudah dikonfigurasi di config/auth.php
        $status = Password::broker('mahasiswas')->sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Menampilkan halaman form reset password (dari link email).
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('mahasiswa.login.reset-password')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Menangani proses update password baru.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::broker('mahasiswas')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password // Cast 'hashed' di model akan menghash otomatis
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('mahasiswa.login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}

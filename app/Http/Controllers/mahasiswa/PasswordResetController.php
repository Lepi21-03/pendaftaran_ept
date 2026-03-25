<?php

namespace App\Http\Controllers\mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PasswordResetService;
use Illuminate\Support\Facades\Password;

class PasswordResetController extends Controller
{
    protected $passwordResetService;

    public function __construct(PasswordResetService $passwordResetService)
    {
        $this->passwordResetService = $passwordResetService;
    }

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

        $status = $this->passwordResetService->sendResetLink($request->only('email'));

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

        $status = $this->passwordResetService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('mahasiswa.login')->with('success', __($status))
            : back()->withErrors(['email' => __($status)]);
    }
}

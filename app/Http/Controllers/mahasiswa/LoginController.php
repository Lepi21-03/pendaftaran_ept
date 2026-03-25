<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LoginService;

class LoginController extends Controller
{
    protected $loginService;

    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'nim'   => 'required',
        ]);

        try {
            $this->loginService->sendMagicLink($request->email, $request->nim);
            return back()->with('success', 'Silahkan Cek Email');
        } catch (\Exception $e) {
            return back()->withErrors($e->getMessage());
        }
    }

    public function verify(string $token)
    {
        $mahasiswa = $this->loginService->verifyToken($token);
        Auth::guard('mahasiswa')->login($mahasiswa);
        return redirect()->route('mahasiswa.ujian.index');
    }
}

<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\LoginService;

class LoginController extends Controller
{
    public function send(Request $request, LoginService $service)
    {
        $request->validate([
            'email' => 'required|email',
            'nim'   => 'required',
        ]);

        try {
            $service->sendMagicLink($request->email, $request->nim);
            return back()-> with('success', 'Silahkan Cek Email');
        } catch (\Exception $e) {
            return back() -> withErrors($e->getMessage());
        }
    }

    public function verify(string $token, LoginService $service)
    {
        $mahasiswa = $service->verifyToken($token);
        Auth::login($mahasiswa);
        return redirect()->route('mahasiswa.ujian.index');
    }
}

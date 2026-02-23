<?php 

namespace App\Services;

use App\Models\Mahasiswa;
use App\Models\LoginToken;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginService
{
    public function sendMagicLink(string $email, string $nim): void
    {
        $mahasiswa = Mahasiswa::where('email', $email)
        ->where('nim', $nim)
        ->first();

        if (!$mahasiswa) {
            throw new \Exception('Data Login Tidak Valid');
        }

        LoginToken::where('mahasiswa_id', $mahasiswa->id)
                ->whereNull('used_at')
                ->delete();

        $plainToken = Str::random(66);
        $hashedToken = Hash::make($plainToken);

        LoginToken::create([
            'mahasiswa_id'=> $mahasiswa->id,
            'token' => $hashedToken,
            'expires_at' => now()->addMinutes(15),
        ]);

        Mail::to($mahasiswa->email)->send(
            new \App\Mail\MagicLoginMail($plainToken)
        );
    }

    public function verifyToken(string $token): Mahasiswa
    {
        $loginToken = LoginToken::whereNull('used_at')
        ->where('expires_at', '>', now())
        ->get();

        $loginToken = $loginToken->first(function ($item) use ($token){
            return Hash::check($token, $item->token);
        });

        if (!$loginToken) {
            throw new \Exception('Link Tidak Valid atau Sudah Kadaluarsa');
        }

        $loginToken->update([
            'used_at' => now(),
        ]);

        return $loginToken->mahasiswa;
    }
}
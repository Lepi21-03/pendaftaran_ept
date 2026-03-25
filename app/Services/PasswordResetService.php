<?php

namespace App\Services;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetService
{
    /**
     * Mengirim email reset password dengan token broker.
     */
    public function sendResetLink(array $credentials): string
    {
        return Password::broker('mahasiswas')->sendResetLink($credentials);
    }

    /**
     * Melakukan reset password untuk user sesuai token.
     */
    public function resetPassword(array $credentials): string
    {
        return Password::broker('mahasiswas')->reset(
            $credentials,
            function ($user, $password) {
                $user->forceFill([
                    'password' => $password // Cast 'hashed' otomatis menghash di model
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );
    }
}

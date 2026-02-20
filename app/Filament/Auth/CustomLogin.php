<?php

namespace App\Filament\Auth;

use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\ViewField;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CustomLogin extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                ViewField::make('recaptcha')
                    ->view('components.recaptcha')
                    ->dehydrated(false),
            ])
            ->statePath('data');
    }

    public function authenticate(): ?\Filament\Auth\Http\Responses\Contracts\LoginResponse
    {
        $recaptchaResponse = $this->data['recaptcha'] ?? '';

        if (empty($recaptchaResponse)) {
            throw ValidationException::withMessages([
                'data.recaptcha' => 'Silakan selesaikan verifikasi reCAPTCHA.',
            ]);
        }

        // Verifikasi reCAPTCHA dengan Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('recaptcha.secret_key'),
            'response' => $recaptchaResponse,
            'remoteip' => request()->ip(),
        ]);

        if (!$response->json('success')) {
            throw ValidationException::withMessages([
                'data.recaptcha' => 'Verifikasi reCAPTCHA gagal. Silakan coba lagi.',
            ]);
        }

        return parent::authenticate();
    }
}

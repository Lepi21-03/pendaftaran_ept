<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Rate limiter untuk registrasi: 5 request per menit per IP
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())
                ->response(function () {
                    return back()->withErrors('Terlalu banyak percobaan. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk login: 5 request per menit per IP+email
        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->input('email', '') . '|' . $request->ip())
                ->response(function () {
                    return back()->withErrors('Terlalu banyak percobaan login. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk resend verifikasi: 3 request per menit per IP
        RateLimiter::for('resend-verifikasi', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip())
                ->response(function () {
                    return back()->withErrors('Terlalu sering mengirim ulang. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk forgot password: 3 request per menit per IP+email
        RateLimiter::for('forgot-password', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip() . '|' . $request->input('email', ''))
                ->response(function () {
                    return back()->withErrors('Terlalu banyak percobaan. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk reset password: 5 request per menit per IP
        RateLimiter::for('reset-password', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip())
                ->response(function () {
                    return back()->withErrors('Terlalu banyak percobaan. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk verifikasi email: 10 request per menit per IP
        RateLimiter::for('verifikasi', function (Request $request) {
            return Limit::perMinute(10)->by($request->ip())
                ->response(function () {
                    return back()->withErrors('Terlalu banyak percobaan verifikasi. Silakan tunggu 1 menit.');
                });
        });

        // Rate limiter untuk cek status pembayaran (AJAX polling): 30 request per menit per IP
        RateLimiter::for('cek-status', function (Request $request) {
            return Limit::perMinute(30)->by($request->ip())
                ->response(function () {
                    return response()->json(['error' => 'Terlalu banyak request.'], 429);
                });
        });
    }
}

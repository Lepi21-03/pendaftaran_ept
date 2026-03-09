<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Routing\Exceptions\InvalidSignatureException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->authenticateSessions();
        $middleware->validateCsrfTokens(except: [
            '/webhook/xendit',
        ]);

        // Daftarkan middleware alias untuk proteksi akses
        $middleware->alias([
            'email.verified'     => \App\Http\Middleware\EnsureEmailVerified::class,
            'pembayaran.success' => \App\Http\Middleware\EnsurePembayaranSuccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Handle signed URL yang expired → tampilkan halaman "link kadaluarsa"
        // daripada default error 403
        $exceptions->renderable(function (InvalidSignatureException $e) {
            return response()->view('mahasiswa.verifikasi.link-expired', [], 403);
        });
    })->create();

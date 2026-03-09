<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable untuk mengirim email verifikasi pendaftaran EPT.
 *
 * Email ini berisi:
 * - Salam kepada user
 * - Tombol "Verifikasi & Lanjutkan Pembayaran" dengan signed URL
 * - Informasi bahwa link berlaku 5 menit
 */
class VerifikasiEmailMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param string $verificationUrl  URL signed untuk verifikasi (expire 5 menit)
     * @param string $namaUser         Nama lengkap user untuk salam di email
     */
    public function __construct(
        public string $verificationUrl,
        public string $namaUser
    ) {}

    /**
     * Subject email yang dikirim.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verifikasi Email - Pendaftaran EPT',
        );
    }

    /**
     * View Blade yang digunakan untuk isi email.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.verifikasi',
        );
    }
}

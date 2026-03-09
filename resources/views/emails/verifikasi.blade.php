<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email - Pendaftaran EPT</title>
</head>
<body style="margin: 0; padding: 0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f4f8;">
    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0f4f8; padding: 40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" width="580" style="background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden;">
                    {{-- Header --}}
                    <tr>
                        <td style="background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); padding: 32px 40px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: 700;">
                                📧 Verifikasi Email Anda
                            </h1>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 40px;">
                            <p style="color: #334155; font-size: 16px; line-height: 1.6; margin: 0 0 16px;">
                                Halo <strong>{{ $namaUser }}</strong>,
                            </p>
                            <p style="color: #475569; font-size: 15px; line-height: 1.6; margin: 0 0 24px;">
                                Terima kasih telah mendaftar untuk <strong>English Proficiency Test (EPT)</strong>. 
                                Silakan klik tombol di bawah ini untuk memverifikasi email Anda dan melanjutkan ke pembayaran.
                            </p>

                            {{-- CTA Button --}}
                            <table role="presentation" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 8px 0 24px;">
                                        <a href="{{ $verificationUrl }}" 
                                           style="display: inline-block; background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%); color: #ffffff; text-decoration: none; padding: 16px 40px; border-radius: 10px; font-size: 16px; font-weight: 700; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);">
                                            ✅ Verifikasi & Lanjutkan Pembayaran
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            {{-- Warning --}}
                            <div style="background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 14px 18px; border-radius: 6px; margin-bottom: 24px;">
                                <p style="color: #92400e; font-size: 13px; margin: 0; line-height: 1.5;">
                                    ⏰ <strong>Link ini hanya berlaku selama 5 menit.</strong> 
                                    Setelah itu, Anda perlu meminta link verifikasi baru.
                                </p>
                            </div>

                            <p style="color: #94a3b8; font-size: 13px; line-height: 1.5; margin: 0;">
                                Jika Anda tidak merasa mendaftar EPT, abaikan email ini.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 40px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="color: #94a3b8; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Sistem Pendaftaran EPT. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Sertifikat EPT - {{ $mahasiswa->name }}</title>
    <style>
        /* ============================================================
         * CSS embedded sederhana — kompatibel dengan DomPDF & browser.
         * Tidak menggunakan Tailwind, CDN, atau font eksternal.
         * Format: A4 Portrait (210mm x 297mm)
         * ============================================================ */
        @page {
            size: a4 portrait;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Pembungkus halaman — A4 portrait */
        .page {
            width: 210mm;
            height: 290mm; /* Dikurangi dari 297mm untuk toleransi DomPDF */
            margin: 0 auto;
            padding: 10mm;
            background: #ffffff;
            overflow: hidden;
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        /* Border luar biru */
        .outer-border {
            width: 100%;
            height: 100%;
            border: 5px solid #1a56c4;
            padding: 5px;
            box-sizing: border-box;
        }

        /* Border dalam biru tipis */
        .inner-border {
            width: 100%;
            height: 100%;
            border: 1.5px solid #1a56c4;
            padding: 16px 22px;
            position: relative;
            box-sizing: border-box;
        }

        /* Sudut dekoratif */
        .corner {
            position: absolute;
            width: 18px;
            height: 18px;
        }
        .corner-tl { top: 7px; left: 7px;   border-top: 3px solid #1a56c4; border-left: 3px solid #1a56c4; }
        .corner-tr { top: 7px; right: 7px;  border-top: 3px solid #1a56c4; border-right: 3px solid #1a56c4; }
        .corner-bl { bottom: 7px; left: 7px;  border-bottom: 3px solid #1a56c4; border-left: 3px solid #1a56c4; }
        .corner-br { bottom: 7px; right: 7px; border-bottom: 3px solid #1a56c4; border-right: 3px solid #1a56c4; }

        /* ---- HEADER ---- */
        .header {
            text-align: center;
            border-bottom: 1.5px solid #1a56c4;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header-label {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #1a56c4;
            margin-bottom: 4px;
        }
        .header-title {
            font-size: 26px;
            font-weight: bold;
            color: #111827;
        }
        .header-subtitle {
            font-size: 10px;
            color: #6b7280;
            font-style: italic;
            margin-top: 4px;
        }

        /* ---- NAMA PENERIMA ---- */
        .recipient-section {
            text-align: center;
            margin-bottom: 16px;
        }
        .recipient-name {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            border-bottom: 2px solid #1a56c4;
            padding-bottom: 6px;
            letter-spacing: 1px;
        }
        .recipient-nim {
            font-size: 10px;
            color: #6b7280;
            font-weight: bold;
            margin-top: 4px;
            letter-spacing: 2px;
        }
        .recipient-desc {
            font-size: 9.5px;
            color: #4b5563;
            margin-top: 10px;
            line-height: 1.7;
        }

        /* ---- SKOR ---- */
        .score-section {
            text-align: center;
            margin-bottom: 16px;
        }
        .score-box {
            display: inline-block;
            border: 2px solid #1a56c4;
            padding: 10px 32px;
            border-radius: 6px;
            background: #f8fafc;
        }
        .score-label {
            font-size: 8px;
            font-weight: bold;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 2px;
        }
        .score-value {
            font-size: 38px;
            font-weight: bold;
            color: #1a56c4;
        }

        /* ---- DIVIDER ---- */
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 14px 0;
        }

        /* ---- FOOTER (tabel tanda tangan) ---- */
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            vertical-align: top;
            padding: 0 6px;
        }
        .info-label {
            font-size: 7.5px;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 2px;
        }
        .info-value {
            font-size: 10px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 8px;
        }
        .cert-id {
            font-size: 8px;
            font-family: 'Courier New', monospace;
            color: #9ca3af;
        }
        .verified-badge {
            font-size: 9px;
            font-weight: bold;
            color: #1a56c4;
            letter-spacing: 1px;
            margin-top: 3px;
        }
        .signature-line {
            width: 100px;
            border-top: 1px solid #374151;
            margin-top: 36px;
            margin-bottom: 3px;
        }
        .signature-name {
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6b7280;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="outer-border">
        <div class="inner-border">

            <!-- Sudut dekoratif -->
            <div class="corner corner-tl"></div>
            <div class="corner corner-tr"></div>
            <div class="corner corner-bl"></div>
            <div class="corner corner-br"></div>

            <!-- Header -->
            <div class="header">
                <div class="header-label">Otoritas Penilaian Global</div>
                <div class="header-title">Certificate of Achievement</div>
                <div class="header-subtitle">Dengan ini secara resmi menyatakan bahwa</div>
            </div>

            <!-- Nama Penerima -->
            <div class="recipient-section">
                <div class="recipient-name">{{ $mahasiswa->name ?? '-' }}</div>
                <div class="recipient-nim">NIM: {{ $mahasiswa->nim ?? '-' }}</div>
                <div class="recipient-desc">
                    telah berhasil menunjukkan kemahiran bahasa Inggris tingkat lanjut melalui
                    <strong>English Proficiency Test (EPT)</strong> yang diselenggarakan di bawah kondisi standar.
                </div>
            </div>

            <!-- Skor -->
            <div class="score-section">
                <div class="score-box">
                    <div class="score-label">Skor EPT</div>
                    <div class="score-value">{{ $mahasiswa->score ?? '-' }}</div>
                </div>
            </div>

            <hr class="divider">

            <!-- Footer -->
            <table class="footer-table">
                <tr>
                    <!-- Kiri: Info -->
                    <td style="width: 35%; text-align: left;">
                        <div class="info-label">Tanggal Terbit</div>
                        <div class="info-value">{{ now()->translatedFormat('d F Y') }}</div>
                        <div class="info-label">Program Studi</div>
                        <div class="info-value">{{ $mahasiswa->prodi ?? '-' }}</div>
                    </td>

                    <!-- Tengah: ID Verifikasi -->
                    <td style="width: 30%; text-align: center; vertical-align: middle;">
                        <div class="cert-id">EPT-CERT-{{ $mahasiswa->nim ?? 'N/A' }}</div>
                        <div class="verified-badge">&#10003; VERIFIED</div>
                    </td>

                    <!-- Kanan: Tanda tangan -->
                    <td style="width: 35%; text-align: right;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="text-align: center; padding: 0 4px;">
                                    <div class="signature-line" style="margin-left: auto;"></div>
                                    <div class="signature-name">Kepala Pusat Bahasa</div>
                                </td>
                                <td style="text-align: center; padding: 0 4px;">
                                    <div class="signature-line" style="margin-left: auto;"></div>
                                    <div class="signature-name">Koordinator EPT</div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

        </div>
    </div>
</div>
</body>
</html>

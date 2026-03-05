<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat EPT - {{ $mahasiswa->name }}</title>
    <style>
        @page {
            size: 297mm 210mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: white;
            width: 297mm;
            height: 210mm;
            line-height: 1.2;
        }
        .container {
            width: 297mm;
            height: 210mm;
            position: relative;
        }
        /* Main Layout Table */
        .wrapper-table {
            width: 100%;
            height: 210mm;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .left-panel {
            width: 60mm;
            background-color: #0097a7; /* Menggunakan warna gelap dari gradien web */
            vertical-align: middle;
            text-align: center;
            color: white;
            padding: 0 10mm;
        }
        .right-panel {
            width: 237mm;
            background-color: #f3f4f6;
            vertical-align: top;
            padding: 15mm 15mm 0 15mm;
            position: relative;
        }
        
        /* Logo & Brand */
        .logo-container {
            margin-bottom: 8mm;
            text-align: center;
        }
        .unw-title {
            font-size: 30pt; /* Sesuaikan dengan 30px web */
            font-weight: bold;
            margin: 0;
            line-height: 1;
        }
        .unw-sub {
            font-size: 11pt; /* Sesuaikan dengan 14px web */
            letter-spacing: 2mm;
            margin-top: 2mm;
            text-transform: uppercase;
        }
        
        /* Info Rows */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2mm;
        }
        .info-label {
            width: 50mm;
            background-color: #43a047;
            color: white;
            font-size: 10.5pt; /* Sesuaikan dengan 14px web */
            font-weight: bold;
            padding: 2.5mm 4mm;
        }
        .info-separator {
            width: 5mm;
            background-color: #43a047;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .info-value {
            background-color: #e5e7eb;
            color: #1f2937;
            font-weight: bold;
            font-size: 10.5pt;
            padding: 2.5mm 4mm;
        }
        .score-label, .score-separator {
            background-color: #9ca3af;
        }
        
        /* Footer Elements */
        .signature-section {
            position: absolute;
            bottom: 35mm;
            right: 15mm;
            width: 80mm;
            text-align: center;
        }
        .signature-title {
            font-size: 9pt; /* Sesuaikan dengan 11px web */
            color: #6b7280;
            margin-bottom: 2mm;
        }
        .signature-container {
            position: relative;
            height: 20mm;
            width: 40mm;
            margin: 0 auto;
        }
        /* Stamp for PDF - Matching web's 70px */
        .stamp {
            position: absolute;
            left: 2mm;
            top: -2mm;
            width: 18.5mm;
            height: 18.5mm;
            border: 0.5mm solid rgba(29, 78, 216, 0.4);
            border-radius: 50%;
            font-size: 4.5pt; /* Sesuaikan dengan 6px web */
            color: rgba(29, 78, 216, 0.6);
            padding-top: 4mm;
            font-weight: bold;
            text-align: center;
            line-height: 1.1;
        }
        /* Signature SVG for PDF - Matching web precisely */
        .signature-svg {
            position: absolute;
            left: 5mm;
            top: 0;
            z-index: 10;
        }

        .signature-name {
            font-size: 10.5pt; /* Sesuaikan dengan 12px web */
            font-weight: bold;
            border-top: 1.2px solid #6b7280;
            padding-top: 1mm;
            display: inline-block;
            width: 100%;
            color: #000;
        }
        
        .barcode-section {
            position: absolute;
            bottom: 35mm;
            left: -145mm;
        }
        .credential-id {
            font-size: 8pt;
            color: #6b7280;
            margin-top: 2mm;
        }
        
        .bottom-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 25mm;
            background-color: #006064; /* Menggunakan warna gelap dari gradien web */
        }
        .report-label {
            background-color: #1b5e20; /* Menggunakan warna gelap dari gradien web */
            color: white;
            font-weight: bold;
            font-size: 14pt; /* Sesuaikan dengan 16px web */
            padding: 3.5mm 8mm;
            margin-left: 15mm;
            margin-top: 6mm;
            display: inline-block;
        }
        .legal-notice {
            position: absolute;
            bottom: 3mm;
            right: 10mm;
            color: #d1d5db;
            font-size: 9pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <table class="wrapper-table">
            <tr>
                <td class="left-panel">
                    <div class="logo-container">
                        <img src="{{ public_path('img/logo-unw.png') }}" alt="Logo UNW" style="width: 40mm; height: auto;">
                    </div>
                    <div class="unw-title">NGUDI</div>
                    <div class="unw-title">WALUYO</div>
                    <div class="unw-sub">UNIVERSITY</div>
                </td>
                <td class="right-panel">
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Name</td>
                            <td class="info-separator">:</td>
                            <td class="info-value">{{ $mahasiswa->name ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Registration Number</td>
                            <td class="info-separator">:</td>
                            <td class="info-value">{{ $mahasiswa->nim ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Program Study</td>
                            <td class="info-separator">:</td>
                            <td class="info-value">{{ $mahasiswa->prodi ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Date of Issue</td>
                            <td class="info-separator">:</td>
                            <td class="info-value">{{ now()->translatedFormat('d F Y') }}</td>
                        </tr>
                    </table>

                    <div style="height: 10mm;"></div>

                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Listening Comprehension</td>
                            <td class="info-separator score-separator">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_listening ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Structure & Writing</td>
                            <td class="info-separator score-separator">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_structure ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Reading Comprehension</td>
                            <td class="info-separator score-separator">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_reading ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Total Score</td>
                            <td class="info-separator">:</td>
                            <td class="info-value" style="text-align: right; background-color: #d1fae5;">{{ $mahasiswa->score ?? '-' }}</td>
                        </tr>
                    </table>

                    <!-- Floating Barcode & Signature inside Right Panel's scope -->
                    <div class="barcode-section">
                        @php
                            $barcodeUrl = 'https://bwipjs-api.metafloor.com/?bcid=code128&text=' . ($mahasiswa->nim ?? '000000') . '&scale=1&rotate=N&includetext=true';
                            try {
                                $barcodeData = base64_encode(file_get_contents($barcodeUrl));
                            } catch (\Exception $e) {
                                $barcodeData = '';
                            }
                        @endphp
                        @if($barcodeData)
                            <img src="data:image/png;base64,{{ $barcodeData }}" width="120" alt="barcode">
                        @endif
                        <div class="credential-id">Verified Credential ID: EPT-{{ $mahasiswa->nim }}</div>
                    </div>

                    <div class="signature-section">
                        <div class="signature-title">The head of language laboratory</div>
                        <div class="signature-container">
                            <!-- Mock Stamp -->
                            <div class="stamp">
                                UNIVERSITAS<br>NGUDI WALUYO
                            </div>
                            <!-- Mock Signature SVG - Precisely matching web path -->
                            <svg width="100" height="50" class="signature-svg">
                                <path d="M 20 40 Q 30 10 45 25 Q 55 40 70 15 Q 80 5 95 30" stroke="#333" stroke-width="1.8" fill="none" />
                            </svg>
                        </div>
                        <div class="signature-name">Maya Kurnia Dewi, S.S., M.Hum</div>
                    </div>
                </td>
            </tr>
        </table>

        <!-- Bottom Bar (Fixed to Container) -->
        <div class="bottom-accent">
            <div class="report-label">English Proficiency Test Report</div>
        </div>
        <div class="legal-notice">
            *Sertifikat EPT hanya bisa digunakan di lingkungan internal Universitas Ngudi Waluyo
        </div>
    </div>
</body>
</html>


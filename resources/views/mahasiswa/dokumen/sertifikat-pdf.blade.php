<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Sertifikat EPT - {{ $mahasiswa->name }}</title>
    <style>
        @page {
            size: 148mm 105mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: white;
            width: 148mm;
            height: 105mm;
            line-height: 1.1;
        }
        .container {
            width: 148mm;
            height: 105mm;
            position: relative;
        }
        /* Main Layout Table */
        .wrapper-table {
            width: 100%;
            height: 105mm;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .left-panel {
            width: 35mm;
            background-color: #0097a7;
            vertical-align: middle;
            text-align: center;
            color: white;
            padding: 0 10mm;
        }
        .right-panel {
            width: 113mm;
            background-color: #f3f4f6;
            vertical-align: top;
            padding: 8mm 10mm 0 10mm;
            position: relative;
        }
        
        /* Logo & Brand */
        .logo-container {
            margin-bottom: 8mm;
            text-align: center;
        }
        .unw-title {
            font-size: 15pt;
            font-weight: bold;
            margin: 0;
            line-height: 1;
        }
        .unw-sub {
            font-size: 7pt;
            letter-spacing: 1mm;
            margin-top: 1mm;
            text-transform: uppercase;
        }
        
        /* Info Rows */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2mm;
        }
        .info-label {
            width: 30mm;
            background-color: #43a047;
            color: white;
            font-size: 7.5pt;
            font-weight: bold;
            padding: 1.5mm 3mm;
        }
        .info-separator {
            width: 3mm;
            background-color: #43a047;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .info-value {
            background-color: #e5e7eb;
            color: #1f2937;
            font-weight: bold;
            font-size: 7.5pt;
            padding: 1.5mm 3mm;
        }
        .score-label, .score-separator {
            background-color: #9ca3af;
        }
        
        /* Footer Elements */
        .signature-section {
            position: absolute;
            bottom: 20mm;
            right: 10mm;
            width: 50mm;
            text-align: center;
        }
        .signature-title {
            font-size: 7pt;
            color: #6b7280;
            margin-bottom: 1.5mm;
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
            left: 1mm;
            top: -1mm;
            width: 12mm;
            height: 12mm;
            border: 0.3mm solid rgba(29, 78, 216, 0.4);
            border-radius: 50%;
            font-size: 3pt;
            color: rgba(29, 78, 216, 0.6);
            padding-top: 2.5mm;
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
            font-size: 7.5pt;
            font-weight: bold;
            border-top: 0.8pt solid #6b7280;
            padding-top: 0.5mm;
            display: inline-block;
            width: 100%;
            color: #000;
        }
        
        .barcode-section {
            position: absolute;
            bottom: 20mm;
            left: -80mm;
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
            height: 15mm;
            background-color: #006064;
        }
        .report-label {
            background-color: #1b5e20;
            color: white;
            font-weight: bold;
            font-size: 9pt;
            padding: 2mm 5mm;
            margin-left: 10mm;
            margin-top: 4mm;
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
                        <img src="{{ public_path('img/logo-unw.png') }}" alt="Logo UNW" style="width: 20mm; height: auto;">
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

                    <div style="height: 5mm;"></div>

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
                            <img src="data:image/png;base64,{{ $barcodeData }}" width="80" alt="barcode">
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
                            <svg width="70" height="35" class="signature-svg">
                                <path d="M 10 30 Q 20 5 35 15 Q 45 30 60 10 Q 70 2 85 20" stroke="#333" stroke-width="1.5" fill="none" />
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


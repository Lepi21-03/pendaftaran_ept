<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat EPT - {{ $mahasiswa->name }}</title>
    <style>
        /* Optimasi khusus DomPDF A4 Landscape */
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
        }
        .certificate-container {
            width: 297mm;
            height: 210mm;
            position: relative;
            overflow: hidden;
            box-sizing: border-box;
        }
        
        .main-table {
            width: 100%;
            height: 185mm; /* Leave space for bottom bar */
            border-collapse: collapse;
        }
        
        .left-panel {
            width: 75mm;
            background-color: #00bcd4; /* DomPDF linear gradient support varies, use solid or simple */
            color: white;
            text-align: center;
            vertical-align: middle;
            padding: 20mm 10mm;
        }
        
        .right-panel {
            background-color: #f3f4f6;
            padding: 15mm 20mm;
            vertical-align: middle;
        }
        
        .logo-circle {
            width: 35mm;
            height: 35mm;
            background-color: #f5c518;
            border: 2mm solid #eab308;
            border-radius: 50%;
            margin: 0 auto 10mm auto;
            padding-top: 5mm;
            box-sizing: border-box;
        }
        
        .unw-title {
            font-size: 28pt;
            font-weight: bold;
            line-height: 1;
            margin: 0;
        }
        
        .unw-sub {
            font-size: 12pt;
            letter-spacing: 2mm;
            margin-top: 2mm;
        }
        
        /* Info Sections */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 3mm;
        }
        .info-label {
            width: 55mm;
            background-color: #43a047;
            color: white;
            font-size: 11pt;
            font-weight: bold;
            padding: 3mm 5mm;
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
            font-size: 11pt;
            padding: 3mm 5mm;
        }
        
        .score-label {
            background-color: #9ca3af;
        }
        .score-separator {
            background-color: #9ca3af;
        }
        
        /* Footer & Signature */
        .footer-table {
            width: 100%;
            background-color: #f3f4f6;
            padding: 0 20mm 10mm 20mm;
        }
        .barcode-area {
            vertical-align: bottom;
            width: 50%;
        }
        .signature-area {
            text-align: center;
            width: 50%;
        }
        
        .bottom-bar {
            position: absolute;
            bottom: 0;
            width: 100%;
            height: 25mm;
            background-color: #00acc1;
            padding: 5mm 20mm;
            box-sizing: border-box;
        }
        
        .report-tag {
            background-color: #43a047;
            color: white;
            font-weight: bold;
            font-size: 14pt;
            padding: 3mm 10mm;
            display: inline-block;
        }
        
        .legal-footer {
            position: absolute;
            bottom: 3mm;
            right: 10mm;
            color: #374151;
            font-size: 9pt;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <table class="main-table">
            <tr>
                <td class="left-panel">
                    <div class="logo-circle">
                        <!-- Simplified Logo for PDF -->
                        <div style="font-size: 6pt; font-weight: bold; color: #0d324d; margin-bottom: 2mm;">UNIVERSITAS NGUDI WALUYO</div>
                        <div style="font-size: 20pt; color: #1a5fa8; font-weight: bold;">UNW</div>
                    </div>
                    <div class="unw-text">
                        <div class="unw-title">NGUDI</div>
                        <div class="unw-title">WALUYO</div>
                        <div class="unw-sub">UNIVERSITY</div>
                    </div>
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

                    <!-- Scores -->
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
                </td>
            </tr>
        </table>

        <!-- Signature Area -->
        <table style="width: 100%; margin-top: -30mm; padding: 0 20mm;">
            <tr>
                <td width="50%">
                    <!-- Barcode placeholder or image -->
                    <div style="font-size: 8pt; color: #666;">Verified Credential ID: EPT-{{ $mahasiswa->nim }}</div>
                </td>
                <td width="50%" style="text-align: center;">
                    <p style="font-size: 10pt; color: #6b7280; margin-bottom: 2mm;">The head of language laboratory</p>
                    <div style="height: 20mm; position: relative;">
                        <!-- Mock Signature -->
                        <div style="font-family: cursive; font-size: 18pt; color: #333; padding-top: 5mm;">Maya Kurnia Dewi</div>
                    </div>
                    <div style="border-bottom: 1px solid #6b7280; width: 60mm; margin: 2mm auto;"></div>
                    <p style="font-size: 11pt; font-weight: bold; margin: 0;">Maya Kurnia Dewi, S.S., M.Hum</p>
                </td>
            </tr>
        </table>

        <div class="bottom-bar">
            <div class="report-tag">
                English Proficiency Test Report
            </div>
        </div>

        <div class="legal-footer">
            *Sertifikat EPT hanya bisa digunakan di lingkungan internal Universitas Ngudi Waluyo
        </div>
    </div>
</body>
</html>

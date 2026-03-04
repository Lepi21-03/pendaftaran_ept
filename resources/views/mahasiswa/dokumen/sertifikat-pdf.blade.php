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
            width: 80mm;
            background-color: #00bcd4;
            vertical-align: middle;
            text-align: center;
            color: white;
            padding: 0 10mm;
        }
        .right-panel {
            width: 217mm;
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
            font-size: 32pt;
            font-weight: bold;
            margin: 0;
            line-height: 1;
        }
        .unw-sub {
            font-size: 14pt;
            letter-spacing: 2mm;
            margin-top: 2mm;
            text-transform: uppercase;
        }
        
        /* Info Rows */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4mm;
        }
        .info-label {
            width: 60mm;
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
            font-size: 10pt;
            color: #4b5563;
            margin-bottom: 15mm;
        }
        .signature-name {
            font-size: 12pt;
            font-weight: bold;
            border-top: 1px solid #4b5563;
            padding-top: 2mm;
            display: inline-block;
            width: 100%;
        }
        
        .barcode-section {
            position: absolute;
            bottom: 35mm;
            left: 15mm;
        }
        .credential-id {
            font-size: 8pt;
            color: #6b7280;
        }
        
        .bottom-accent {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 25mm;
            background-color: #00acc1;
        }
        .report-label {
            background-color: #43a047;
            color: white;
            font-weight: bold;
            font-size: 16pt;
            padding: 4mm 10mm;
            margin-left: 15mm;
            margin-top: 5mm;
            display: inline-block;
        }
        .legal-notice {
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
    <div class="container">
        <table class="wrapper-table">
            <tr>
                <td class="left-panel">
                    <div class="logo-container">
                        <img src="{{ public_path('img/logo-unw.png') }}" alt="Logo UNW" style="width: 45mm; height: auto;">
                    </div>
                    <div class="unw-title">NGUDI</div>
                    <div class="unw-title">WALUYO</div>
                    <div class="unw-sub">University</div>
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
                        <div class="credential-id">Verified Credential ID: EPT-{{ $mahasiswa->nim }}</div>
                    </div>

                    <div class="signature-section">
                        <div class="signature-title">The head of language laboratory</div>
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


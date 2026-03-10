@php
    $ujian = $record->ujian;
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>Kartu Ujian - {{ $record->nama_lengkap }}</title>
    <style>
        /* Optimasi khusus DomPDF */
        @page {
            size: 210mm 297mm;
            margin: 0;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            background-color: white;
            width: 210mm;
            height: 297mm;
        }
        .card-container {
            width: 90mm;
            height: 55mm;
            margin: 10mm auto;
            border: 1px solid #000;
            background: white;
            padding: 4mm;
            position: relative;
            box-sizing: border-box;
            overflow: hidden;
        }
        .header-table {
            width: 100%;
            border-bottom: 1pt solid #000;
            margin-bottom: 3mm;
            padding-bottom: 2mm;
        }
        .title {
            font-size: 10pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            text-align: center;
        }
        .subtitle {
            font-size: 7pt;
            color: #475569;
            margin-top: 1mm;
            text-align: center;
        }
        
        .main-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-cell {
            vertical-align: top;
        }
        .label-cell {
            width: 30mm;
            font-weight: bold;
            font-size: 8pt;
            padding: 1.5mm 0;
        }
        .value-cell {
            font-size: 8pt;
            padding: 1.5mm 0;
            font-weight: bold;
        }
        
        
        .footer-table {
            width: 100%;
            margin-top: 2mm;
        }
        .notes-box {
            font-size: 6pt;
            font-style: italic;
            width: 60%;
        }
        .sig-box {
            text-align: right;
            font-size: 8pt;
        }
        .sig-line {
            border-bottom: 0.5pt solid #000;
            width: 30mm;
            margin: 5mm 0 1mm auto;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 30pt;
            font-weight: bold;
            color: rgba(0, 0, 0, 0.03);
            z-index: -1;
            white-space: nowrap;
        }
    </style>
</head>
<body>
    <div class="card-container">
        <div class="watermark">EPT UNW</div>
        
        <table class="header-table">
            <tr>
                <td width="30" style="vertical-align: middle;">
                    <div style="width: 10mm; height: 10mm;">
                        <img src="{{ public_path('img/logo-unw.png') }}" alt="Logo UNW" style="width: 100%; height: auto;">
                    </div>
                </td>
                <td class="header-text">
                    <div class="title">KARTU PESERTA UJIAN</div>
                    <div class="subtitle">English Proficiency Test (EPT) - UNW</div>
                </td>
                <td width="50" style="text-align: right; font-size: 6pt; font-weight: bold; vertical-align: top;">
                    ID: EPT-{{ $record->id }}
                </td>
            </tr>
        </table>

        <table class="main-table">
            <tr>
                <td class="info-cell">
                    <table width="100%">
                        <tr>
                            <td class="label-cell">Nama Lengkap</td>
                            <td width="5">:</td>
                            <td class="value-cell">{{ $record->nama_lengkap }}</td>
                        </tr>
                        <tr>
                            <td class="label-cell">NIM</td>
                            <td>:</td>
                            <td class="value-cell">{{ $record->nim }}</td>
                        </tr>
                        <tr>
                            <td class="label-cell">ID Ujian</td>
                            <td>:</td>
                            <td class="value-cell">UJIAN-{{ $ujian->id }}</td>
                        </tr>
                        <tr>
                            <td class="label-cell">Tanggal Ujian</td>
                            <td>:</td>
                            <td class="value-cell">{{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td class="label-cell">Ruang Ujian</td>
                            <td>:</td>
                            <td class="value-cell">{{ $ujian->lokasi ?? 'Lab Bahasa 1' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Absolute QR Code for PDF -->
        <div style="position: absolute; bottom: 3mm; right: 3mm; width: 10mm; height: 10mm; background: white; border: 0.5pt solid #eee; padding: 0.5mm;">
            <img src="{{ $qrCode }}" alt="QR Code" style="width: 100%; height: 100%;">
        </div>
    </div>
</body>
</html>

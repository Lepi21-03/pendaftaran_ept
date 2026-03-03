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
            width: 170mm;
            margin: 20mm auto;
            border: 2px solid #000;
            background: white;
            padding: 10mm;
            position: relative;
            box-sizing: border-box;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #000;
            margin-bottom: 15mm;
            padding-bottom: 5mm;
        }
        .title {
            font-size: 20pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 0;
            text-align: center;
        }
        .subtitle {
            font-size: 12pt;
            color: #475569;
            margin-top: 2mm;
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
            width: 40mm;
            font-weight: bold;
            font-size: 11pt;
            padding: 3mm 0;
        }
        .value-cell {
            font-size: 11pt;
            padding: 3mm 0;
            font-weight: bold;
        }
        
        .photo-area {
            width: 30mm;
            height: 40mm;
            border: 1px solid #000;
            text-align: center;
            vertical-align: middle;
            font-size: 10pt;
            color: #64748b;
            margin-left: 5mm;
        }
        
        .footer-table {
            width: 100%;
            margin-top: 20mm;
        }
        .notes-box {
            font-size: 9pt;
            font-style: italic;
            width: 60%;
        }
        .sig-box {
            text-align: right;
            font-size: 11pt;
        }
        .sig-line {
            border-bottom: 1px solid #000;
            width: 50mm;
            margin: 15mm 0 2mm auto;
        }
        
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-30deg);
            font-size: 60pt;
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
                <td width="50" style="vertical-align: middle;">
                    <div style="width: 15mm; height: 15mm;">
                        <img src="data:image/png;base64,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">
                    </div>
                </td>
                <td class="header-text">
                    <div class="title">KARTU PESERTA UJIAN</div>
                    <div class="subtitle">English Proficiency Test (EPT) - UNW</div>
                </td>
                <td width="70" style="text-align: right; font-size: 8pt; font-weight: bold; vertical-align: top;">
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
                <td width="35mm" style="vertical-align: top;">
                    <div class="photo-area">
                        <br><br><br>
                        PAS FOTO<br>3 x 4
                    </div>
                </td>
            </tr>
        </table>

        <table class="footer-table">
            <tr>
                <td class="notes-box">
                    <strong>PENTING:</strong><br>
                    * Harap membawa kartu ini saat ujian.<br>
                    * Datang 15 menit sebelum ujian dimulai.<br>
                    * Membawa alat tulis (Pensil 2B & Penghapus).
                </td>
                <td class="sig-box">
                    Ungaran, {{ now()->translatedFormat('d F Y') }}<br>
                    Ketua Pelaksana,<br>
                    <div class="sig-line"></div>
                    (___________________)
                </td>
            </tr>
        </table>
    </div>
</body>
</html>

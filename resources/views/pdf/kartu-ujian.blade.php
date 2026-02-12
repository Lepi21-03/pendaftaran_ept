<html>
<head>
    <title>Kartu Ujian EPT</title>
    <style>
        @page {
            size: 15cm 10cm;
            margin: 0;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 15cm;
            height: 10cm;
        }
        .card-container {
            width: 15cm;
            height: 10cm;
            border: 3px solid #000;
            box-sizing: border-box;
            position: relative;
            padding: 0.5cm;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        .logo {
            width: 50px;
            height: auto;
        }
        .title {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 5px 0;
        }
        .subtitle {
            font-size: 11px;
            margin-bottom: 5px;
        }
        .content-wrapper {
            display: table;
            width: 100%;
        }
        .left-section {
            display: table-cell;
            width: 70%;
            vertical-align: top;
            padding-right: 10px;
        }
        .right-section {
            display: table-cell;
            width: 30%;
            vertical-align: top;
            text-align: right;
        }
        .info-row {
            margin-bottom: 6px;
            font-size: 11px;
        }
        .info-label {
            display: inline-block;
            width: 100px;
            font-weight: bold;
        }
        .info-value {
            display: inline;
        }
        .photo-box {
            width: 3cm;
            height: 4cm;
            border: 2px solid #000;
            text-align: center;
            line-height: 4cm;
            font-size: 10px;
            color: #999;
            background-color: #f5f5f5;
        }
        .footer {
            position: absolute;
            bottom: 0.5cm;
            right: 0.5cm;
            font-size: 9px;
            text-align: right;
        }
        .signature-section {
            margin-top: 20px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 120px;
            display: inline-block;
            text-align: center;
            margin-top: 30px;
            padding-top: 3px;
        }
        .notes {
            position: absolute;
            bottom: 0.3cm;
            left: 0.5cm;
            font-size: 7px;
            font-style: italic;
            color: #666;
        }
        .card-number {
            position: absolute;
            top: 0.3cm;
            right: 0.5cm;
            font-size: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="card-container">
        <div class="card-number">No: EPT-{{ $record->id }}</div>
        
        <div class="header">
            <!-- Tambahkan logo jika ada -->
            <!-- <img src="{{ public_path('logo.png') }}" class="logo"> -->
            <div class="title">KARTU PESERTA UJIAN</div>
            <div class="subtitle">English Proficiency Test (EPT)</div>
        </div>

        <div class="content-wrapper">
            <div class="left-section">
                <div class="info-row">
                    <span class="info-label">Nama</span>
                    <span class="info-value">: {{ $record->name }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">NPM/NIK</span>
                    <span class="info-value">: {{ $record->npm ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Program Studi</span>
                    <span class="info-value">: {{ $record->prodi ?? '-' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Tanggal Ujian</span>
                    <span class="info-value">: {{ now()->format('d M Y') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Ruang Ujian</span>
                    <span class="info-value">: Lab Bahasa 1</span>
                </div>
            </div>
            
            <div class="right-section">
                <div class="photo-box">
                    Foto<br>3x4
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="signature-section">
                <div>Bandar Lampung, {{ now()->format('d M Y') }}</div>
                <div style="margin-top: 3px;">Ketua Pelaksana,</div>
                <div class="signature-line">
                    (Nama Ketua)
                </div>
            </div>
        </div>

        <div class="notes">
            * Harap membawa kartu ini saat ujian | * Datang 15 menit sebelum ujian
        </div>
    </div>

</body>
</html>
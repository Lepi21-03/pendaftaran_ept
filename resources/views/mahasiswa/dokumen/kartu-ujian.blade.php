@php
    $ujian = $record->ujian;
@endphp
<style>
    /* Reset for DomPDF */
    @page {
        size: a4 portrait;
        margin: 1cm;
    }
    body {
        margin: 0;
        padding: 0;
    }
    .card-container {
        width: 100%;
        max-width: 190mm; /* Sesuai lebar A4 dikurangi margin */
        min-height: 120mm;
        border: 2px solid #000;
        box-sizing: border-box;
        position: relative;
        padding: 0.8cm;
        background: white;
        color: black;
        margin: 0 auto;
        font-family: Arial, sans-serif;
        overflow: hidden;
        page-break-inside: avoid;
    }
    .header {
        text-align: center;
        border-bottom: 2px solid #000;
        padding-bottom: 5px;
        margin-bottom: 12px;
    }
    .title {
        font-size: 16px;
        font-weight: bold;
        text-transform: uppercase;
        margin: 5px 0;
    }
    .subtitle {
        font-size: 12px;
        margin-bottom: 5px;
    }
    .content-wrapper {
        display: table;
        width: 100%;
        border-collapse: collapse;
    }
    .left-section {
        display: table-cell;
        width: 70%;
        vertical-align: top;
    }
    .right-section {
        display: table-cell;
        width: 30%;
        vertical-align: top;
        text-align: right;
    }
    .info-row {
        margin-bottom: 8px;
        font-size: 12px;
    }
    .info-label {
        display: inline-block;
        width: 90px;
        font-weight: bold;
    }
    .photo-box {
        width: 2.8cm;
        height: 3.8cm;
        border: 1px solid #000;
        display: inline-block;
        text-align: center;
        line-height: 3.8cm;
        font-size: 11px;
        color: #999;
        background-color: #f5f5f5;
    }
    .footer {
        position: absolute;
        bottom: 0.4cm;
        right: 0.5cm;
        font-size: 11px;
        text-align: right;
    }
    .signature-line {
        border-top: 1px solid #000;
        width: 140px;
        display: inline-block;
        text-align: center;
        margin-top: 35px;
        padding-top: 3px;
    }
    .notes {
        position: absolute;
        bottom: 0.2cm;
        left: 0.8cm;
        font-size: 10px;
        font-style: italic;
        color: #666;
    }
    .card-number {
        position: absolute;
        top: 0.2cm;
        right: 0.8cm;
        font-size: 11px;
        font-weight: bold;
    }
</style>

<div class="card-container">
    <div class="card-number">No: EPT-{{ $record->id }}</div>
    
    <div class="header">
        <div class="title">KARTU PESERTA UJIAN</div>
        <div class="subtitle">English Proficiency Test (EPT)</div>
    </div>

    <div class="content-wrapper">
        <div class="left-section">
            <div class="info-row">
                <span class="info-label">Nama Lengkap</span>
                <span class="info-value">: {{ $record->nama_lengkap }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">NIM</span>
                <span class="info-value">: {{ $record->nim }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">ID Ujian</span>
                <span class="info-value">: UJIAN-{{ $ujian->id }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tanggal Ujian</span>
                <span class="info-value">: {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->translatedFormat('d F Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Ruang Ujian</span>
                <span class="info-value">: {{ $ujian->lokasi ?? 'Lab Bahasa 1' }}</span>
            </div>
        </div>
        
        <div class="right-section">
            <div class="photo-box">
                Foto 3x4
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="signature-section">
            <div>Ungaran, {{ now()->translatedFormat('d F Y') }}</div>
            <div style="margin-top: 5px;">Ketua Pelaksana,</div>
            <div class="signature-line">
                (___________________)
            </div>
        </div>
    </div>

    <div class="notes">
        * Harap membawa kartu ini saat ujian | * Datang 15 menit sebelum ujian
    </div>
</div>
@php
    $ujian = $record->ujian;
@endphp
<style>
    /* Reset for DomPDF */
    @page {
        size: a4 portrait;
        margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
        font-family: 'Helvetica', 'Arial', sans-serif;
    }
    .full-page-wrapper {
        width: 100%;
        display: block;
        background-color: #f1f5f9;
        padding: 20px 0;
    }
    @media print {
        .full-page-wrapper { 
            height: 297mm; 
            background-color: white; 
            padding: 0;
            padding-top: 20mm;
        }
    }
    .card-container {
        width: 90mm;
        height: 55mm;
        margin: 0 auto;
        border: 2px solid #000;
        background: white;
        padding: 5mm;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }
    .header-table {
        width: 100%;
        border-bottom: 1.5px solid #000;
        margin-bottom: 8px;
        padding-bottom: 5px;
    }
    .unw-logo-small {
        width: 35px;
        height: 35px;
        text-align: center;
    }

    .unw-logo-small img {
        width: 100%;
        height: auto;
        margin-top: -10px;
    }
    .header-text {
        text-align: center;
    }
    .title {
        font-size: 11px;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 0.5px;
    }
    .subtitle {
        font-size: 8px;
        color: #475569;
        margin-top: 1px;
    }
    
    .main-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-cell {
        vertical-align: top;
        padding-top: 10px;
    }
    .label-cell {
        width: 80px;
        font-weight: bold;
        font-size: 9px;
        padding: 2px 0;
        color: #1e293b;
    }
    .value-cell {
        font-size: 9px;
        padding: 2px 0;
        color: #000;
        font-weight: bold;
    }

    
    .footer-table {
        width: 100%;
        margin-top: 40px;
    }
    .notes-box {
        font-size: 7px;
        font-style: italic;
        color: #475569;
        border-left: 2px solid #00bcd4;
        padding-left: 5px;
    }
    .sig-box {
        text-align: right;
        font-size: 9px;
    }
    .sig-line {
        border-bottom: 1px solid #000;
        width: 100px;
        display: inline-block;
        margin-top: 15px;
    }
    
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        font-size: 30px;
        font-weight: 900;
        color: rgba(0, 188, 212, 0.05);
        z-index: 0;
        pointer-events: none;
        white-space: nowrap;
    }
    
    @media print {
        .full-page-wrapper { background: white; padding-top: 0; }
        .card-container { box-shadow: none; border-width: 1px; margin: 0; }
    }
</style>

<div class="full-page-wrapper">
    <div class="card-container">
        <div class="watermark">EPT PORTAL</div>
        
        <table class="header-table">
            <tr>
                <td width="40">
                    <div class="unw-logo-small">
                        <img src="{{ asset('img/logo-unw.png') }}" alt="Logo UNW">
                    </div>
                </td>
                <td class="header-text">
                    <div class="title">KARTU PESERTA UJIAN</div>
                    <div class="subtitle">English Proficiency Test (EPT) - UNW</div>
                </td>
                <td width="50" style="text-align: right; font-size: 7px; font-weight: bold;">
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
                            <td width="10">:</td>
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

        <table class="footer-table">
            <tr>
                <td class="notes-box">
                    <strong>PENTING:</strong><br>
                    * Harap membawa kartu ini saat ujian.<br>
                    * Datang 15 menit sebelum ujian dimulai.
                </td>
                <td class="sig-box">
                    Ungaran, {{ now()->translatedFormat('d F Y') }}<br>
                    Ketua Pelaksana,<br>
                    <div class="sig-line"></div><br>
                    (___________________)
                </td>
            </tr>
        </table>
    </div>
</div>
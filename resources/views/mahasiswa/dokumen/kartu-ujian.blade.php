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
        padding: 40px 0;
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
        width: 180mm;
        margin: 0 auto;
        border: 4px double #000;
        background: white;
        padding: 1.5cm;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        position: relative;
        min-height: 120mm;
    }
    .header-table {
        width: 100%;
        border-bottom: 3px solid #000;
        margin-bottom: 25px;
        padding-bottom: 15px;
    }
    .unw-logo-small {
        width: 60px;
        height: 60px;
        background: #f5c518;
        border-radius: 50%;
        text-align: center;
        padding-top: 8px;
    }
    .header-text {
        text-align: center;
    }
    .title {
        font-size: 24px;
        font-weight: 900;
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 2px;
    }
    .subtitle {
        font-size: 16px;
        color: #475569;
        margin-top: 5px;
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
        width: 140px;
        font-weight: bold;
        font-size: 14px;
        padding: 10px 0;
        color: #1e293b;
    }
    .value-cell {
        font-size: 14px;
        padding: 10px 0;
        color: #000;
        font-weight: bold;
    }
    
    .photo-area {
        width: 3cm;
        height: 4cm;
        border: 2px solid #94a3b8;
        background: #f8fafc;
        text-align: center;
        vertical-align: middle;
        font-size: 12px;
        color: #64748b;
    }
    
    .footer-table {
        width: 100%;
        margin-top: 40px;
    }
    .notes-box {
        font-size: 11px;
        font-style: italic;
        color: #475569;
        border-left: 3px solid #00bcd4;
        padding-left: 10px;
    }
    .sig-box {
        text-align: right;
        font-size: 14px;
    }
    .sig-line {
        border-bottom: 1px solid #000;
        width: 180px;
        display: inline-block;
        margin-top: 50px;
    }
    
    .watermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) rotate(-30deg);
        font-size: 80px;
        font-weight: 900;
        color: rgba(0, 188, 212, 0.05);
        z-index: 0;
        pointer-events: none;
        white-space: nowrap;
    }
    
    @media print {
        .full-page-wrapper { background: white; padding-top: 0; }
        .card-container { box-shadow: none; border-width: 2px; margin-top: 20mm; }
    }
</style>

<div class="full-page-wrapper">
    <div class="card-container">
        <div class="watermark">EPT PORTAL</div>
        
        <table class="header-table">
            <tr>
                <td width="70">
                    <div class="unw-logo-small">
                        <svg width="40" height="40" viewBox="0 0 80 80">
                            <circle cx="40" cy="40" r="36" fill="#1a5fa8" />
                            <rect x="22" y="57" width="36" height="6" rx="2" fill="#e8d44d" />
                        </svg>
                    </div>
                </td>
                <td class="header-text">
                    <div class="title">KARTU PESERTA UJIAN</div>
                    <div class="subtitle">English Proficiency Test (EPT) - UNW</div>
                </td>
                <td width="70" style="text-align: right; font-size: 10px; font-weight: bold;">
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
                <td width="3cm" style="vertical-align: top; padding-top: 10px;">
                    <div class="photo-area">
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
                    <div class="sig-line"></div><br>
                    (___________________)
                </td>
            </tr>
        </table>
    </div>
</div>
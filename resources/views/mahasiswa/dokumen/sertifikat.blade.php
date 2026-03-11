{{-- Sertifikat View - Kompatibel Web & PDF --}}
<style>
    @page {
        size: a4 landscape;
        margin: 0;
    }
    body {
        margin: 0;
        padding: 0;
    }
    .certificate-wrapper {
        width: 100%;
        background-color: #f8fafc;
        display: block;
        position: relative;
        font-family: 'Helvetica', 'Arial', sans-serif;
        padding-bottom: 40px;
    }
    @media print {
        .certificate-wrapper { 
            height: 210mm; 
            padding-bottom: 0;
            background-color: white; 
        }
        .cert-card { box-shadow: none; top: 0; border: 1px solid #ddd; }
        .no-print { display: none !important; }
    }
    .cert-card {
        width: 800px; /* Kembali ke lebar landscape yang lebih proporsional di layar */
        margin: 0 auto;
        background: white;
        box-shadow: 0 15px 30px -5px rgb(0 0 0 / 0.15);
        border-radius: 6px;
        overflow: hidden;
        position: relative;
        top: 10mm;
    }
    .cert-table {
        width: 100%;
        border-collapse: collapse;
        min-height: 450px; /* Pastikan ada tinggi minimal agar terlihat landscape */
    }
    .cert-table {
        width: 100%;
        border-collapse: collapse;
        min-height: 380px;
    }
    .left-panel {
        width: 220px;
        background: linear-gradient(160deg, #00bcd4 0%, #0097a7 100%);
        text-align: center;
        vertical-align: middle;
        padding: 20px 12px;
    }
    .right-panel {
        background: #f3f4f6;
        padding: 20px 25px;
        vertical-align: middle;
    }
    .logo-circle {
        width: 100px;
        margin: 0 auto 15px auto;
        display: block;
        background: transparent;
    }
    .unw-text {
        color: white;
        text-align: center;
    }
    .unw-title {
        font-size: 20px;
        font-weight: 900;
        line-height: 1;
        letter-spacing: 0.5px;
    }
    .unw-sub {
        font-size: 12px;
        letter-spacing: 1.5px;
        margin-top: 2px;
    }
    
    /* Info Row using Table for stability */
    .info-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 8px;
    }
    .info-label {
        width: 150px;
        background: linear-gradient(90deg, #43a047, #66bb6a);
        color: white;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 10px;
        position: relative;
    }
    /* Arrow effect for PDF (Clip path replacement) */
    .info-label::after {
        content: "";
        position: absolute;
        right: 0;
        top: 0;
        width: 0;
        height: 0;
        border-top: 13px solid transparent;
        border-bottom: 13px solid transparent;
        border-left: 8px solid #66bb6a;
        margin-right: -8px;
        z-index: 10;
    }
    .info-separator {
        width: 15px;
        background: #66bb6a;
        color: white;
        font-weight: bold;
        text-align: center;
        padding: 5px 0;
    }
    .info-value {
        background: #e5e7eb;
        color: #1f2937;
        font-weight: bold;
        font-size: 12px;
        padding: 5px 10px;
    }
    
    .score-label {
        background: #9ca3af;
    }
    .score-label::after {
        border-left-color: #9ca3af;
    }
    
    /* Footer & Signature */
    .footer-table {
        width: 100%;
        background: #f3f4f6;
        padding: 0 25px 15px 25px;
    }
    .barcode-area {
        vertical-align: bottom;
        padding-bottom: 10px;
    }
    .signature-area {
        text-align: center;
        width: 150px;
    }
    
    .bottom-bar {
        background: linear-gradient(90deg, #00acc1, #006064);
        padding: 10px 20px;
    }
    .report-tag {
        background: linear-gradient(90deg, #43a047, #1b5e20);
        color: white;
        font-weight: 800;
        font-size: 11px;
        padding: 6px 15px;
        display: inline-block;
        border-radius: 3px;
    }
    .legal-footer {
        background: #374151;
        color: #d1d5db;
        font-size: 12px;
        font-style: italic;
        padding: 10px 32px;
    }
    
    @media print {
        .no-print { display: none !important; }
        .cert-card { box-shadow: none; top: 0; border: 1px solid #ddd; }
        .certificate-wrapper { background: white; }
    }
</style>

<div class="certificate-wrapper">
    <!-- Action Bar (Hidden on Print) -->
    <div class="no-print" style="max-width: 800px; margin: 0 auto; padding: 15px 0; display: flex; justify-content: space-between; align-items: flex-end;">
        <div>
            <h1 style="font-size: 24px; font-weight: 900; margin: 0;">Digital Certificate</h1>
            <p style="color: #64748b; margin: 3px 0 0 0; font-size: 14px;">Official verified credential for your EPT result.</p>
        </div>
    </div>

    <div class="cert-card">
        <table class="cert-table">
            <tr>
                <td class="left-panel">
                    <div class="logo-circle">
                        <img src="{{ asset('img/logo-unw.png') }}" alt="Logo UNW" style="width: 100px; height: auto; margin: 0 auto; display: block;">
                    </div>
                    <div class="unw-text">
                        <div class="unw-title">NGUDI</div>
                        <div class="unw-title">WALUYO</div>
                        <div class="unw-sub">UNIVERSITY</div>
                    </div>
                </td>
                <td class="right-panel">
                    <!-- Info Sections -->
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

                    <div style="height: 10px;"></div>

                    <!-- Scores -->
                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Listening Comprehension</td>
                            <td class="info-separator" style="background: #9ca3af;">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_listening ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Structure & Writing</td>
                            <td class="info-separator" style="background: #9ca3af;">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_structure ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label score-label">Reading Comprehension</td>
                            <td class="info-separator" style="background: #9ca3af;">:</td>
                            <td class="info-value" style="text-align: right;">{{ $mahasiswa->score_reading ?? '-' }}</td>
                        </tr>
                    </table>
                    <table class="info-table">
                        <tr>
                            <td class="info-label">Total Score</td>
                            <td class="info-separator">:</td>
                            <td class="info-value" style="text-align: right; background: #d1fae5;">{{ $mahasiswa->score ?? '-' }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- Signature & Barcode Section -->
        <table class="footer-table">
            <tr>
                <td class="barcode-area">
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents('https://bwipjs-api.metafloor.com/?bcid=code128&text=' . ($mahasiswa->nim ?? '000000') . '&scale=1&rotate=N&includetext=true')) }}" width="100" alt="barcode">
                </td>
                <td class="signature-area">
                    <p style="font-size: 9px; color: #6b7280; margin-bottom: 3px;">The head of language laboratory</p>
                    <div style="position: relative; height: 80px;">
                        <!-- Mock Stamp -->
                        <div style="position: absolute; left: 15px; top: 0; width: 50px; height: 50px; border: 1.5px solid rgba(29, 78, 216, 0.4); border-radius: 50%; font-size: 4px; color: rgba(29, 78, 216, 0.6); padding-top: 10px; font-weight: bold;">
                            UNIVERSITAS<br>NGUDI WALUYO
                        </div>
                        <!-- Mock Signature Path -->
                        <svg width="80" height="40" style="position: relative; z-index: 2;">
                            <path d="M 10 30 Q 20 5 35 15 Q 45 30 60 10 Q 70 2 85 20" stroke="#333" stroke-width="1.5" fill="none" />
                        </svg>
                    </div>
                    <div style="border-bottom: 1.5px solid #6b7280; width: 100%; margin: 5px 0;"></div>
                    <p style="font-size: 10px; font-weight: bold; margin: 0;">Maya Kurnia Dewi, S.S., M.Hum</p>
                </td>
            </tr>
        </table>

        <div class="bottom-bar">
            <div class="report-tag">
                English Proficiency Test Report
            </div>
        </div>

        <div class="legal-footer">
            *The EPT certificate is only valid for internal use at Ngudi Waluyo University.
        </div>
    </div>
</div>
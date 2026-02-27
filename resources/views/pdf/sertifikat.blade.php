<!DOCTYPE html>
<html>
<head>
    <title>Sertifikat EPT</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        /* Jika menggunakan background image */
        /* .background { position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; } */
        
        .content {
            padding-top: 15vh; /* Sesuaikan dengan desain background */
            width: 80%;
            margin: 0 auto;
        }

        h1 {
            font-size: 3em;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 0px;
        }
        h2 {
            font-size: 1.5em;
            margin-top: 10px;
            text-transform: uppercase;
        }
        
        .recipient {
            font-size: 2em;
            font-weight: bold;
            margin-top: 40px;
            border-bottom: 2px solid #333;
            display: inline-block;
            padding: 5px 20px;
        }

        .score-box {
            margin-top: 50px;
            font-size: 1.2em;
        }
        .score-value {
            font-size: 2em;
            font-weight: bold;
            color: #d90429;
        }

        .date {
            margin-top: 50px;
            font-size: 1.2em;
        }

        .signature {
            margin-top: 80px;
            display: flex; /* Flexbox mungkin tidak work sempurna di DomPDF, gunakan float atau table */
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .signature-item {
            width: 40%;
            display: inline-block;
            vertical-align: top;
        }
    </style>
</head>
<body>
    <!-- <img src="{{ public_path('images/certificate-bg.jpg') }}" class="background"> -->

    <div class="content">
        <h1>SERTIFIKAT</h1>
        <h2>ENGLISH PROFICIENCY TEST</h2>
        <p>Diberikan kepada:</p>

        <div class="recipient">
            {{ $record->name }}
        </div>
        
        <p style="margin-top: 20px;">Atas partisipasinya dalam tes kemampuan bahasa Inggris yang dilaksanakan pada tanggal {{ now()->format('d F Y') }}.</p>

        <div class="score-box">
            <span>Dengan Skor Akhir:</span><br>
            <span class="score-value">{{ $record->score ?? '-' }}</span>
        </div>

        <div class="signature">
            <div class="signature-item">
                <p>Mengetahui,</p>
                <br><br><br>
                <b>___________________</b><br>
                Kepala Pusat Bahasa
            </div>
            <div class="signature-item">
                <p>Penanggung Jawab,</p>
                <br><br><br>
                <b>___________________</b><br>
                Koordinator EPT
            </div>
        </div>
    </div>
</body>
</html>


<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset="utf-8"/>
<title>Sertifikat EPT - {{ $mahasiswa->name }}</title>

<style>

        @page{
            size:A6 landscape;
            margin:0;
        }

        body{
            margin:0;
            padding:0;
            width:148mm;
            height:105mm;
            font-family:Helvetica, Arial, sans-serif;
            overflow:hidden;
        }

        .container{
            width:148mm;
            height:105mm;
            position:relative;
            overflow:hidden;
        }

        .wrapper{
            width:100%;
            height:90mm;
            border-collapse:collapse;
            table-layout:fixed;
        }   

        .left{
            width:42mm;
            background:#0097a7;
            text-align:center;
            color:white;
            vertical-align:middle;
        }

        .logo{
            width:18mm;
            margin-bottom:3mm;
        }

        .unw-title{
            font-size:14pt;
            font-weight:bold;
            line-height:1;
        }

        .unw-sub{
            font-size:5pt;
            letter-spacing:0.8mm;
        }

        .right{
            background:#f3f4f6;
            padding:4mm;
            vertical-align:top;
        }

        .info{
            width:100%;
            border-collapse:collapse;
            margin-bottom:1mm;
        }

        .label{
            width:30mm;
            background:#43a047;
            color:white;
            font-size:6.5pt;
            font-weight:bold;
            padding:1.2mm;
        }

        .sep{
            width:3mm;
            background:#43a047;
            color:white;
            text-align:center;
            font-size:6.5pt;
        }

        .val{
            background:#e5e7eb;
            font-size:6.5pt;
            font-weight:bold;
            padding:1.2mm;
        }

        .scorelabel,
        .scoresep{
            background:#9ca3af;
        }

        .footer{
            width:100%;
            margin-top:2mm;
        }

        .barcode{
            width:45%;
            text-align:center;
            padding-top: 2mm;
            padding-left: 10mm;
        }

        .sign{
            text-align:center;
            width:50%;
            padding-right:10mm;
        }

        .sig-title{
            font-size:6pt;
            color:#6b7280;
            margin-bottom:1mm;
        }

        .sig-area{
            height:16mm;
            position:relative;
        }

        .stamp{
            position:absolute;
            left:10mm;
            top:1mm;
            width:15mm;
            height:15mm;
            border:1px solid rgba(29,78,216,0.4);
            border-radius:50%;
            font-size:4pt;
            text-align:center;
            padding-top:3.5mm;
            color:rgba(29,78,216,0.6);
            font-weight:bold;
        }

        .sig-name{
            font-size:7.5pt;
            font-weight:bold;
            border-top:1px solid #555;
            margin-top:1mm;
            padding-top:0.5mm;
            width: 100%;
            display: inline-block;
        }

        .bottom{
            position:absolute;
            bottom:0;
            left:0;
            width:100%;
            height:10mm;
            background:#006064;
            z-index: 10;
        }

        .report{
            background:#1b5e20;
            color:white;
            font-size:7pt;
            font-weight:bold;
            padding:1.2mm 4mm;
            display:inline-block;
            margin-left:8mm;
            margin-top:2.5mm;
        }

        .legal{
            position:absolute;
            right:8mm;
            bottom:3mm;
            font-size:4.5pt;
            color:#d1d5db;
            font-style:italic;
            z-index: 20;
        }

</style>
</head>

<body>

<div class="container">

<table class="wrapper">

<tr>

<td class="left">

<img src="{{ public_path('img/logo-unw.png') }}" class="logo">

<div class="unw-title">NGUDI</div>
<div class="unw-title">WALUYO</div>
<div class="unw-sub">UNIVERSITY</div>

</td>

<td class="right">

<table class="info">
<tr>
<td class="label">Name</td>
<td class="sep">:</td>
<td class="val">{{ $mahasiswa->name ?? '-' }}</td>
</tr>
</table>

@php
    $regYear = !empty($mahasiswa->test_date) ? \Carbon\Carbon::parse($mahasiswa->test_date)->year : now()->year;
    $regNim = $mahasiswa->nim ?? '';
    $regText = $regNim ? "EPT - {$regYear} - {$regNim}" : '-';
@endphp
<table class="info">
<tr>
<td class="label">Registration Number</td>
<td class="sep">:</td>
<td class="val">{{ $regText }}</td>
</tr>
</table>

<table class="info">
<tr>
<td class="label">Program Study</td>
<td class="sep">:</td>
<td class="val">{{ $mahasiswa->prodi ?? '-' }}</td>
</tr>
</table>

<table class="info">
<tr>
<td class="label">Test Date</td>
<td class="sep">:</td>
<td class="val">{{ now()->translatedFormat('d F Y') }}</td>
</tr>
</table>

<div style="height:1mm"></div>

<table class="info">
<tr>
<td class="label scorelabel">Listening Comprehension</td>
<td class="sep scoresep">:</td>
<td class="val" style="text-align:center">{{ $mahasiswa->score_listening ?? '-' }}</td>
</tr>
</table>

<table class="info">
<tr>
<td class="label scorelabel">Structure & Writing</td>
<td class="sep scoresep">:</td>
<td class="val" style="text-align:center">{{ $mahasiswa->score_structure ?? '-' }}</td>
</tr>
</table>

<table class="info">
<tr>
<td class="label scorelabel">Reading Comprehension</td>
<td class="sep scoresep">:</td>
<td class="val" style="text-align:center">{{ $mahasiswa->score_reading ?? '-' }}</td>
</tr>
</table>

<table class="info">
<tr>
<td class="label">Total Score</td>
<td class="sep">:</td>
<td class="val" style="text-align:center;background:#d1fae5">
{{ $mahasiswa->score ?? '-' }}
</td>
</tr>
</table>

@php
    $isEnglish = strtolower(trim($mahasiswa->prodi ?? '')) === 'bahasa inggris';
    $scoreValue = (int)($mahasiswa->score ?? 0);
    if ($isEnglish) {
        $isLulus = $scoreValue >= 450;
    } else {
        $isLulus = $scoreValue >= 400;
    }
    $statusText = $isLulus ? 'LULUS' : 'TIDAK LULUS';
    $statusColor = $isLulus ? '#15803d' : '#dc2626';
    $statusBg = $isLulus ? '#dcfce7' : '#fee2e2';
@endphp
<table class="info">
<tr>
<td class="label" style="background: {{ $statusColor }};">Status</td>
<td class="sep" style="background: {{ $statusColor }};">:</td>
<td class="val" style="text-align:center;background: {{ $statusBg }};color: {{ $statusColor }};font-weight:bold;letter-spacing:1px;">
{{ $statusText }}
</td>
</tr>
</table>

</td>
</tr>

<tr>
<td colspan="2" style="padding: 0 5mm;">

<table class="footer">

<tr>

<td class="barcode">

@php
    $regYear = !empty($mahasiswa->test_date) ? \Carbon\Carbon::parse($mahasiswa->test_date)->year : now()->year;
    $regNim = $mahasiswa->nim ?? '000000';
    $regTextBarcode = "EPT - {$regYear} - {$regNim}";
    $barcodeUrl = 'https://bwipjs-api.metafloor.com/?bcid=code128&text=' . urlencode($regTextBarcode) . '&scale=2&height=10&rotate=N&includetext=true';
    try {
        $barcodeData = base64_encode(file_get_contents($barcodeUrl));
    } catch(Exception $e) {
        $barcodeData = '';
    }
@endphp

@if($barcodeData)
<img src="data:image/png;base64,{{ $barcodeData }}" height="45" style="width: auto;">
@endif

<div style="font-size:6pt;color:#6b7280;margin-top:2mm">
Verified Credential ID: {{ $regTextBarcode }}
</div>

</td>

<td class="sign">

<div class="sig-title">
The head of language laboratory
</div>

<div class="sig-area">

</div>

<div class="sig-name">
Maya Kurnia Dewi, S.S., M.Hum
</div>

</td>

</tr>

</table>

</td>

</tr>

</table>

<div class="bottom">
<div class="report">
English Proficiency Test Report
</div>
</div>

<div class="legal">
*Sertifikat EPT hanya bisa digunakan di lingkungan internal Universitas Ngudi Waluyo
</div>

</div>

</body>
</html>


@extends('layout')

@section('title', 'Beranda - Pendaftaran EPT')

@section('content')
    <div style="text-align: center; padding: 40px 0;">
        <h1 style="color: var(--primary-color); margin-bottom: 20px;">Selamat Datang di Sistem Pendaftaran EPT</h1>
        <p style="font-size: 1.2rem; color: #555; max-width: 800px; margin: 0 auto; margin-bottom: 30px;">
            Daftarkan diri Anda untuk mengikuti tes EPT (English Proficiency Test) dengan mudah dan cepat.
            Silakan login atau daftar untuk memulai.
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="#" style="
                display: inline-block;
                padding: 12px 24px;
                background-color: var(--primary-color);
                color: white;
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: background-color 0.3s;
            " onmouseover="this.style.backgroundColor='#2980b9'" onmouseout="this.style.backgroundColor='var(--primary-color)'">
                Daftar Sekarang
            </a>
            
            <a href="#" style="
                display: inline-block;
                padding: 12px 24px;
                background-color: transparent;
                color: var(--primary-color);
                border: 2px solid var(--primary-color);
                text-decoration: none;
                border-radius: 5px;
                font-weight: bold;
                transition: all 0.3s;
            " onmouseover="this.style.backgroundColor='var(--primary-color)'; this.style.color='white'" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--primary-color)'">
                Lihat Jadwal
            </a>
        </div>
    </div>

    <!-- Section Fitur -->
    <div style="margin-top: 50px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="color: var(--secondary-color); margin-bottom: 10px;">Mudah & Cepat</h3>
            <p>Proses pendaftaran yang simpel dan tidak memakan waktu lama.</p>
        </div>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="color: var(--secondary-color); margin-bottom: 10px;">Jadwal Fleksibel</h3>
            <p>Pilih jadwal tes yang sesuai dengan ketersediaan waktu Anda.</p>
        </div>
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
            <h3 style="color: var(--secondary-color); margin-bottom: 10px;">Hasil Akurat</h3>
            <p>Dapatkan hasil tes EPT yang terpercaya untuk keperluan akademik Anda.</p>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Official Certificate of Proficiency - EPT Portal')

@section('content')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        .print-only {
            display: block !important;
        }
        body {
            background: white !important;
        }
        .certificate-card {
            box-shadow: none !important;
            border: 1px solid #e2e8f0 !important;
            margin: 0 !important;
            width: 100% !important;
        }
    }
    .certificate-bg-pattern {
        background-image: radial-gradient(circle at 2px 2px, rgba(19, 127, 236, 0.05) 1px, transparent 0);
        background-size: 24px 24px;
    }
    @keyframes spin-slow {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin-slow {
        animation: spin-slow 12s linear infinite;
    }
</style>

<main class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Breadcrumb (Hidden on Print) -->
    <nav class="no-print flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 mb-8">
        <a class="hover:text-primary" href="{{ route('mahasiswa.ujian.index') }}">Home</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">My Certificates</span>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-slate-900 dark:text-slate-100 font-medium">EPT-2023-8842</span>
    </nav>

    <!-- Certificate Header (Hidden on Print) -->
    <div class="no-print mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight mb-2">Sertifikat Digital Anda</h1>
            <p class="text-slate-600 dark:text-slate-400">Kredensial digital terverifikasi untuk hasil English Proficiency Test (EPT) Anda.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-lg text-sm font-semibold hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-[20px]">share</span>
                Share
            </button>
            <button class="flex items-center gap-2 bg-primary text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-md" onclick="window.print()">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak PDF
            </button>
        </div>
    </div>

    <!-- The Certificate Document -->
    <div class="certificate-card bg-white dark:bg-slate-900 border-[12px] border-primary/10 rounded-xl shadow-2xl overflow-hidden relative p-8 md:p-16 mb-12">
        <!-- Background Decorative Elements -->
        <div class="absolute inset-0 certificate-bg-pattern opacity-50 pointer-events-none"></div>
        <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-primary/5 rounded-full -ml-32 -mb-32 blur-3xl pointer-events-none"></div>
        
        <div class="relative z-10 border-4 border-primary/20 p-4 md:p-8 rounded-lg">
            <!-- Certificate Header Content -->
            <div class="flex flex-col items-center text-center mb-12">
                <div class="mb-6">
                    <div class="bg-primary/10 w-20 h-20 rounded-full flex items-center justify-center mb-4 mx-auto">
                        <span class="material-symbols-outlined text-primary text-5xl">school</span>
                    </div>
                    <h2 class="text-primary font-bold tracking-[0.2em] uppercase text-sm mb-2">Otoritas Penilaian Global</h2>
                    <h3 class="text-4xl md:text-5xl font-black text-slate-900 mb-2">Certificate of Achievement</h3>
                    <p class="text-slate-500 font-medium italic">Dengan ini secara resmi menyatakan bahwa</p>
                </div>

                <!-- Recipient Name -->
                <div class="mb-10 w-full max-w-2xl">
                    <div class="text-4xl md:text-6xl font-bold text-slate-900 py-4 border-b-2 border-primary/30 inline-block w-full uppercase">
                        Alexander Raymond
                    </div>
                    <p class="mt-6 text-slate-600 max-w-lg mx-auto leading-relaxed">
                        telah berhasil menunjukkan kemahiran bahasa Inggris tingkat lanjut melalui 
                        <span class="font-bold">English Proficiency Test (EPT)</span> yang diselenggarakan di bawah kondisi standar.
                    </p>
                </div>

                <!-- Scores Grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 w-full max-w-4xl mb-12">
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-lg">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Listening</p>
                        <p class="text-2xl font-black text-slate-900">88</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-lg">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Reading</p>
                        <p class="text-2xl font-black text-slate-900">92</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-lg">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Writing</p>
                        <p class="text-2xl font-black text-slate-900">85</p>
                    </div>
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-lg">
                        <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Speaking</p>
                        <p class="text-2xl font-black text-slate-900">94</p>
                    </div>
                </div>

                <!-- Total Score & Date -->
                <div class="flex flex-col md:flex-row items-center gap-12 mb-12">
                    <div class="flex flex-col items-center">
                        <div class="w-32 h-32 rounded-full border-8 border-primary flex flex-col items-center justify-center bg-primary/5">
                            <span class="text-3xl font-black text-primary leading-none">359</span>
                            <span class="text-[10px] font-bold text-primary uppercase mt-1">Total Score</span>
                        </div>
                    </div>
                    <div class="text-center md:text-left">
                        <div class="mb-4">
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Test Date</p>
                            <p class="text-lg font-bold text-slate-900">October 24, 2023</p>
                        </div>
                        <div>
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Location</p>
                            <p class="text-lg font-bold text-slate-900">Regional Center</p>
                        </div>
                    </div>
                </div>

                <!-- Certificate Footer & Verification -->
                <div class="w-full flex flex-col md:flex-row items-center justify-between border-t border-slate-100 pt-10 gap-8">
                    <!-- ID & Stamp -->
                    <div class="flex items-center gap-6">
                        <div class="relative w-24 h-24">
                            <div class="absolute inset-0 rounded-full border-2 border-dashed border-primary/40 animate-spin-slow"></div>
                            <div class="absolute inset-2 rounded-full border-2 border-primary/20"></div>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
                                <span class="text-[8px] font-bold text-primary mt-1">VERIFIED</span>
                            </div>
                        </div>
                        <div class="text-left">
                            <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest mb-1">Certificate ID</p>
                            <p class="text-sm font-mono font-bold text-slate-900">EPT-CERT-2023-8842-X8Y</p>
                            <p class="text-[10px] text-slate-400 mt-1">Validasi di verify.ept-portal.org</p>
                        </div>
                    </div>
                    <!-- Signatures -->
                    <div class="flex gap-12">
                        <div class="text-center">
                            <div class="mb-2 h-12 flex items-end justify-center">
                                <p class="font-serif italic text-2xl text-slate-800">Sarah Jenkins</p>
                            </div>
                            <div class="w-32 border-t border-slate-300 mx-auto pt-2">
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Director of Studies</p>
                            </div>
                        </div>
                        <div class="text-center">
                            <div class="mb-2 h-12 flex items-end justify-center">
                                <p class="font-serif italic text-2xl text-slate-800">Dr. Marc Thorne</p>
                            </div>
                            <div class="w-32 border-t border-slate-300 mx-auto pt-2">
                                <p class="text-[10px] font-bold text-slate-500 uppercase">Head Examiner</p>
                            </div>
                        </div>
                    </div>
                    <!-- QR Code Placeholder -->
                    <div class="bg-slate-100 p-2 rounded">
                        <div class="w-16 h-16 bg-white border border-slate-200 flex items-center justify-center">
                            <span class="material-symbols-outlined text-slate-300 text-5xl">qr_code_2</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Info (Hidden on Print) -->
    <section class="no-print grid md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">info</span>
                Memahami Skor Anda
            </h4>
            <div class="space-y-4 text-sm text-slate-600 dark:text-slate-400">
                <p>Skor English Proficiency Test (EPT) berkisar antara 0 hingga 400. Setiap komponen diberi bobot yang sama.</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li><strong>Lanjutan (320-400):</strong> Dapat memahami berbagai teks yang sulit, lebih panjang, dan mengenali makna tersirat.</li>
                    <li><strong>Menengah Atas (240-319):</strong> Dapat berinteraksi dengan tingkat kefasihan dan spontanitas tertentu.</li>
                    <li><strong>Menengah (160-239):</strong> Dapat menghasilkan teks terhubung sederhana tentang topik yang sudah dikenal.</li>
                </ul>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <h4 class="text-lg font-bold mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">security</span>
                Pemeriksaan Keaslian
            </h4>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-4">
                Sertifikat ini dilindungi oleh teknologi verifikasi berbasis blockchain. Instansi mana pun dapat memverifikasi keasliannya dengan memindai kode QR atau mengunjungi portal verifikasi resmi kami.
            </p>
            <div class="p-4 bg-primary/5 rounded-lg border border-primary/10">
                <p class="text-xs font-bold text-primary uppercase mb-1">URL Verifikasi</p>
                <p class="text-sm font-mono break-all text-slate-700 dark:text-slate-300">https://ept-portal.org/verify/EPT-2023-8842-X8Y</p>
            </div>
        </div>
    </section>
</main>
@endsection

@extends('layouts.app')

@section('title', 'Official Certificate of Proficiency - EPT Portal')

@section('content')
<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; margin: 0; padding: 0; }
        .certificate-container { scale: 1; transform-origin: top left; padding: 0 !important; box-shadow: none !important; }
    }
    .clip-arrow {
        clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 50%, calc(100% - 12px) 100%, 0 100%);
    }
</style>

<div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <!-- Action Bar (Hidden on Print) -->
    <div class="no-print mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tight mb-2">Digital Certificate</h1>
            <p class="text-slate-600 dark:text-slate-400">Official verified credential for your English Proficiency Test (EPT) result.</p>
        </div>
        <div class="flex gap-3">
            <button class="flex items-center gap-2 bg-primary text-white px-6 py-2.5 rounded-lg text-sm font-bold hover:bg-primary/90 transition-all shadow-md" onclick="window.print()">
                <span class="material-symbols-outlined text-[20px]">print</span>
                Cetak Sertifikat
            </button>
        </div>
    </div>

    <!-- ═══ CERTIFICATE CARD ═══ -->
    <div class="certificate-container w-full max-w-[900px] mx-auto bg-white rounded-lg overflow-hidden shadow-2xl flex flex-col mb-12">
        
        <!-- ═══ MAIN CONTENT ═══ -->
        <div class="flex min-h-[380px]">

            <!-- Left Panel - Teal Branding -->
            <div class="w-64 min-w-[256px] flex flex-col items-center justify-center gap-5 px-5 py-8"
                style="background: linear-gradient(160deg, #00bcd4 0%, #0097a7 100%)">

                <!-- Logo Circle -->
                <div class="w-32 h-32 rounded-full flex items-center justify-center border-4 border-yellow-500"
                    style="background: #f5c518;">
                    <div class="flex flex-col items-center gap-1">
                        <span class="text-[6.5px] font-bold text-blue-900 text-center leading-tight">UNIVERSITAS NGUDI WALUYO</span>
                        <!-- Globe SVG -->
                        <svg width="58" height="58" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="40" cy="40" r="36" fill="#1a5fa8" stroke="#0d3d70" stroke-width="2"/>
                            <ellipse cx="40" cy="40" rx="16" ry="36" fill="none" stroke="#7ec8e3" stroke-width="1.5"/>
                            <ellipse cx="40" cy="40" rx="36" ry="10" fill="none" stroke="#7ec8e3" stroke-width="1.5"/>
                            <ellipse cx="40" cy="40" rx="36" ry="22" fill="none" stroke="#7ec8e3" stroke-width="1.2"/>
                            <line x1="40" y1="4" x2="40" y2="76" stroke="#7ec8e3" stroke-width="1.5"/>
                            <line x1="4" y1="40" x2="76" y2="40" stroke="#7ec8e3" stroke-width="1.5"/>
                            <rect x="22" y="57" width="36" height="6" rx="2" fill="#e8d44d" stroke="#b8a800" stroke-width="1"/>
                            <rect x="24" y="55" width="14" height="8" rx="1" fill="#f5e97e"/>
                            <rect x="42" y="55" width="14" height="8" rx="1" fill="#f5e97e"/>
                        </svg>
                        <span class="text-[7.5px] font-bold text-blue-900">★ UNW ★</span>
                    </div>
                </div>

                <!-- University Name -->
                <div class="text-center text-white">
                    <div class="text-3xl font-black leading-none tracking-wide">NGUDI</div>
                    <div class="text-3xl font-black leading-none tracking-wide">WALUYO</div>
                    <div class="text-sm font-normal tracking-[3px] mt-1">UNIVERSITY</div>
                </div>
            </div>

            <!-- Right Panel - Data Fields -->
            <div class="flex-1 bg-gray-100 flex flex-col justify-center px-10 py-9 gap-0">

                <!-- Info Fields -->
                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">Name</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">:</div>
                    <div class="flex-1 flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->name ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">Registration Number</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">:</div>
                    <div class="flex-1 flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->nim ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">Program Study</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">:</div>
                    <div class="flex-1 flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->prodi ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">Test Date</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">:</div>
                    <div class="flex-1 flex items-center px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ now()->translatedFormat('d F Y') }}</div>
                </div>

                <!-- Score Fields -->
                <div class="flex items-stretch mt-2 mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold bg-gray-400">
                        Listening Comprehension</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm bg-gray-400">:</div>
                    <div class="flex-1 flex items-center justify-end px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->score_listening ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold bg-gray-400">
                        Structure and Writing Expression</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm bg-gray-400">:</div>
                    <div class="flex-1 flex items-center justify-end px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->score_structure ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold bg-gray-400">
                        Reading Comprehension</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm bg-gray-400">:</div>
                    <div class="flex-1 flex items-center justify-end px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->score_reading ?? '-' }}</div>
                </div>

                <div class="flex items-stretch mb-2">
                    <div class="clip-arrow flex items-center px-4 pr-7 min-w-[210px] py-2 text-white text-sm font-semibold"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">Total Score</div>
                    <div class="flex items-center px-1.5 py-2 text-white font-bold text-sm"
                        style="background: linear-gradient(90deg, #43a047, #66bb6a)">:</div>
                    <div class="flex-1 flex items-center justify-end px-4 py-2 bg-gray-200 text-gray-800 font-bold text-sm">{{ $mahasiswa->score ?? '-' }}</div>
                </div>

            </div>
        </div>

        <!-- ═══ SIGNATURE AREA ═══ -->
        <div class="flex items-center justify-between px-10 pb-5 pt-2 bg-gray-100">
            <!-- Barcode - kiri mentok -->
            <div class="flex flex-col items-start gap-1">
                <svg height="50" viewBox="0 0 200 40" xmlns="http://www.w3.org/2000/svg">
                    <rect width="200" height="40" fill="white"/>
                    <g fill="#111">
                        <rect x="2"   y="2" width="3" height="36"/><rect x="7"   y="2" width="1" height="36"/>
                        <rect x="10"  y="2" width="4" height="36"/><rect x="16"  y="2" width="1" height="36"/>
                        <rect x="19"  y="2" width="2" height="36"/><rect x="23"  y="2" width="3" height="36"/>
                        <rect x="28"  y="2" width="1" height="36"/><rect x="31"  y="2" width="4" height="36"/>
                        <rect x="37"  y="2" width="2" height="36"/><rect x="41"  y="2" width="1" height="36"/>
                        <rect x="44"  y="2" width="3" height="36"/><rect x="49"  y="2" width="2" height="36"/>
                        <rect x="53"  y="2" width="1" height="36"/><rect x="56"  y="2" width="4" height="36"/>
                        <rect x="62"  y="2" width="2" height="36"/><rect x="66"  y="2" width="1" height="36"/>
                        <rect x="69"  y="2" width="3" height="36"/><rect x="74"  y="2" width="1" height="36"/>
                        <rect x="77"  y="2" width="2" height="36"/><rect x="81"  y="2" width="4" height="36"/>
                        <rect x="87"  y="2" width="1" height="36"/><rect x="90"  y="2" width="3" height="36"/>
                        <rect x="95"  y="2" width="2" height="36"/><rect x="99"  y="2" width="1" height="36"/>
                        <rect x="102" y="2" width="4" height="36"/><rect x="108" y="2" width="2" height="36"/>
                        <rect x="112" y="2" width="1" height="36"/><rect x="115" y="2" width="3" height="36"/>
                        <rect x="120" y="2" width="1" height="36"/><rect x="123" y="2" width="2" height="36"/>
                        <rect x="127" y="2" width="4" height="36"/><rect x="133" y="2" width="1" height="36"/>
                        <rect x="136" y="2" width="3" height="36"/><rect x="141" y="2" width="2" height="36"/>
                        <rect x="145" y="2" width="1" height="36"/><rect x="148" y="2" width="4" height="36"/>
                        <rect x="154" y="2" width="1" height="36"/><rect x="157" y="2" width="2" height="36"/>
                        <rect x="161" y="2" width="3" height="36"/><rect x="166" y="2" width="1" height="36"/>
                        <rect x="169" y="2" width="4" height="36"/><rect x="175" y="2" width="2" height="36"/>
                        <rect x="179" y="2" width="1" height="36"/><rect x="182" y="2" width="3" height="36"/>
                        <rect x="187" y="2" width="2" height="36"/><rect x="191" y="2" width="1" height="36"/>
                        <rect x="194" y="2" width="4" height="36"/>
                    </g>
                </svg>
                <span class="text-xs font-mono text-gray-500 tracking-widest">*{{ $mahasiswa->nim ?? '0000000' }}*</span>
            </div>

            <!-- Tanda tangan - kanan -->
            <div class="text-center">
                <p class="text-sm text-gray-500 mb-2">The head of language laboratory</p>
                <div class="relative w-44 h-24 flex items-center justify-center">
                    <!-- Stamp -->
                    <div class="absolute left-2 top-1 w-[90px] h-[90px] rounded-full border-2 border-blue-700 opacity-60 flex items-center justify-center">
                        <span class="text-[6.5px] font-bold text-blue-700 text-center leading-tight">UNIVERSITAS<br>NGUDI WALUYO<br>⭐ UNW ⭐</span>
                    </div>
                    <!-- Signature -->
                    <svg width="176" height="70" viewBox="0 0 176 70" class="relative z-10">
                        <path d="M 60 55 Q 70 20 85 35 Q 95 50 110 25 Q 120 15 135 40 Q 140 50 150 45"
                            stroke="#333" stroke-width="2" fill="none" stroke-linecap="round"/>
                        <path d="M 65 60 Q 80 45 90 55 Q 100 65 115 50 Q 125 38 140 52"
                            stroke="#333" stroke-width="1.5" fill="none" stroke-linecap="round"/>
                    </svg>
                </div>
                <div class="border-b-2 border-gray-500 w-44 mx-auto mb-1"></div>
                <p class="text-sm font-bold text-gray-800">Maya Kurnia Dewi, S.S., M.Hum</p>
            </div>
        </div>

        <!-- ═══ BOTTOM BAR ═══ -->
        <div class="flex items-center px-8 py-4"
            style="background: linear-gradient(90deg, #00acc1, #006064)">
            <div class="text-white font-extrabold text-base px-6 py-2.5 rounded shrink-0"
                style="background: linear-gradient(90deg, #43a047, #1b5e20)">
                English Proficiency Test Report
            </div>
        </div>

        <!-- ═══ FOOTER ═══ -->
        <div class="bg-gray-700 px-8 py-2.5 text-gray-300 text-xs italic">
            *Sertifikat EPT hanya bisa digunakan di lingkungan internal Universitas Ngudi Waluyo
        </div>

    </div>

</div>
@endsection

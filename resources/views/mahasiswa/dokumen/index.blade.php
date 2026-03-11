@extends('layouts.app')

@section('title', 'Dokumen Saya - EPT Portal')

@section('content')
<main id="main-content" class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

    <div class="space-y-12">
        <!-- Section Kartu Ujian -->
        <section class="bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50">
                <div>
                    <h2 class="text-xl font-bold">Exam Participant Card</h2>
                    <p class="text-sm text-slate-500">Use this card as your ID during the exam.</p>
                </div>
                @if($pendaftaran)
                {{-- Hanya tombol unduh PDF server-side --}}
                <a href="{{ route('mahasiswa.dokumen.kartu-ujian.download') }}"
                   class="no-print flex items-center gap-2 bg-primary text-white px-5 py-2 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-md">
                    <span class="material-symbols-outlined">download</span>
                    Download Card (PDF)
                </a>
                @endif
            </div>
            
            <div class="p-8 flex justify-center bg-slate-50/30 dark:bg-slate-900/30" id="card-area">
                @if($pendaftaran)
                    @include('mahasiswa.dokumen.kartu-ujian', ['record' => $pendaftaran])
                @else
                    <div class="text-center py-10 w-full">
                        <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 p-4 rounded-xl text-amber-800 dark:text-amber-400 inline-block">
                            <p class="flex items-center gap-2 font-bold">
                                <span class="material-symbols-outlined">warning</span>
                                Exam Card Not Available Yet
                            </p>
                            <p class="text-sm mt-1">Your payment has not been verified or registration is not active.</p>
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Section Sertifikat -->
        <section class="bg-white dark:bg-slate-900 rounded-xl shadow-lg border border-slate-200 dark:border-slate-800 overflow-hidden">
            <div class="p-6 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center bg-slate-50 dark:bg-slate-800/50">
                <div>
                    <h2 class="text-xl font-bold">Exam Certificate</h2>
                    <p class="text-sm text-slate-500">Official certificate of English Proficiency Test results.</p>
                </div>
                @if($mahasiswa->score && $mahasiswa->score > 0)
                {{-- Hanya tombol unduh PDF server-side --}}
                <a href="{{ route('mahasiswa.dokumen.sertifikat.download') }}"
                   class="no-print flex items-center gap-2 bg-primary text-white px-5 py-2 rounded-lg font-bold hover:bg-primary/90 transition-all shadow-md">
                    <span class="material-symbols-outlined">download</span>
                    Download Certificate (PDF)
                </a>
                @endif
            </div>

            <div class="p-8 flex justify-center bg-slate-50/30 dark:bg-slate-900/30" id="certificate-area">
                @if($mahasiswa->score && $mahasiswa->score > 0)
                    <div class="w-full">
                        @include('mahasiswa.dokumen.sertifikat')
                    </div>
                @else
                    <div class="text-center py-20 w-full">
                        <div class="mb-4 text-slate-300 dark:text-slate-700">
                            <span class="material-symbols-outlined text-7xl">article</span>
                        </div>
                        <h3 class="text-lg font-medium text-slate-600 dark:text-slate-400">"Download certificate here after the exam"</h3>
                        <p class="text-sm text-slate-400 dark:text-slate-500 mt-2">The certificate will appear automatically after the Admin uploads your EPT score results.</p>
                    </div>
                @endif
            </div>
        </section>
    </div>
</main>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

@endsection

{{--
    Halaman "Link Verifikasi Kadaluarsa"
    Ditampilkan ketika user mengklik link verifikasi yang sudah expired (> 5 menit).
    Fitur:
    - Pesan error link kadaluarsa
    - Form untuk meminta link verifikasi baru
--}}
@extends('layouts.app')

@section('title', 'Link Kadaluarsa | EPT Portal')

@section('content')
<main class="flex-grow flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-[480px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 sm:p-10">
            {{-- Icon & Title --}}
            <div class="mb-8 text-center">
                <div class="mx-auto w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined text-red-500 text-4xl">timer_off</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Link Verifikasi Telah Kadaluarsa</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    Link verifikasi email Anda sudah tidak berlaku. Silakan minta link verifikasi baru.
                </p>
            </div>

            {{-- Resend Form --}}
            <form action="{{ route('mahasiswa.verifikasi.resend') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block" for="email">Email Address</label>
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                            <input class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" 
                                   id="email" name="email" placeholder="Masukkan email Anda" required type="email" />
                        </div>
                    </div>
                    <button type="submit" 
                        class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span>
                        <span>Kirim Link Verifikasi Baru</span>
                    </button>
                </div>
            </form>

            @if(session('success'))
                <div class="mt-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm text-center">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Back --}}
            <div class="mt-6 text-center">
                <a href="{{ route('mahasiswa.ujian.index') }}" class="text-sm text-slate-500 hover:text-primary transition-colors">
                    ← Kembali ke halaman ujian
                </a>
            </div>
        </div>
    </div>
</main>
@endsection

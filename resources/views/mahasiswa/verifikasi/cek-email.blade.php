{{--
    Halaman "Cek Email Anda"
    Ditampilkan HANYA setelah registrasi dan SEBELUM pembayaran selesai.
    
    Fitur:
    - Pesan instruksi verifikasi email
    - Countdown timer 5 menit
    - Tombol "Kirim Ulang Email Verifikasi" (muncul setelah countdown habis)
--}}
@extends('layouts.app')

@section('title', 'Cek Email Anda | EPT Portal')

@section('content')
<main class="flex-grow flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-[520px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 sm:p-10">
            {{-- Icon & Title --}}
            <div class="mb-8 text-center">
                <div class="mx-auto w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-5">
                    <span class="material-symbols-outlined text-primary text-4xl">mark_email_read</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Cek Email Anda</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                    Kami telah mengirim email verifikasi ke:
                </p>
                <p class="text-primary font-semibold mt-1">
                    {{ session('verification_email', 'email anda') }}
                </p>
            </div>

            {{-- Info Box --}}
            <div class="mb-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                    <div>
                        <p class="text-sm text-blue-800 dark:text-blue-300 leading-relaxed">
                            Silakan buka email Anda dan klik tombol <strong>"Verifikasi & Lanjutkan Pembayaran"</strong> 
                            untuk memverifikasi akun dan melanjutkan ke pembayaran.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Countdown Timer --}}
            <div class="mb-6 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-2">Link verifikasi berlaku selama:</p>
                <div id="countdown" class="text-3xl font-bold text-slate-900 dark:text-white font-mono tracking-wider">
                    05:00
                </div>
                <p id="expired-text" class="hidden text-red-500 font-semibold text-sm mt-2">
                    ⏰ Link verifikasi telah kadaluarsa!
                </p>
            </div>

            {{-- Resend Button (hidden until countdown ends) --}}
            <div id="resend-section" class="hidden">
                <form action="{{ route('mahasiswa.verifikasi.resend') }}" method="POST">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('verification_email') }}">
                    <input type="hidden" name="daftar_id" value="{{ session('verification_daftar_id') }}">
                    <button type="submit" 
                        class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">send</span>
                        <span>Kirim Ulang Email Verifikasi</span>
                    </button>
                </form>
            </div>

            {{-- Success message after resend --}}
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

            {{-- Back to registration --}}
            <div class="mt-6 text-center">
                <a href="{{ route('mahasiswa.ujian.index') }}" class="text-sm text-slate-500 hover:text-primary transition-colors">
                    ← Kembali ke halaman ujian
                </a>
            </div>
        </div>
    </div>
</main>

<script>
    // Countdown Timer 5 menit
    (function() {
        const countdownEl = document.getElementById('countdown');
        const expiredTextEl = document.getElementById('expired-text');
        const resendSection = document.getElementById('resend-section');

        let totalSeconds = 5 * 60; // 5 menit

        function updateTimer() {
            const minutes = Math.floor(totalSeconds / 60);
            const seconds = totalSeconds % 60;
            countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

            if (totalSeconds <= 0) {
                countdownEl.classList.add('text-red-500');
                expiredTextEl.classList.remove('hidden');
                resendSection.classList.remove('hidden');
                return;
            }

            // Warna berubah kuning saat < 1 menit
            if (totalSeconds <= 60) {
                countdownEl.classList.remove('text-slate-900', 'dark:text-white');
                countdownEl.classList.add('text-amber-500');
            }

            totalSeconds--;
            setTimeout(updateTimer, 1000);
        }

        updateTimer();
    })();
</script>
@endsection

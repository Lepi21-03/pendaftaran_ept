{{--
    Halaman "Cek Email Anda"
    Ditampilkan setelah registrasi, saat menunggu verifikasi email.
    
    Fitur:
    - Countdown timer 5 menit
    - Tombol "Kirim Ulang Email Verifikasi" setelah countdown habis
    - POLLING: Setiap 3 detik mengecek status pembayaran via AJAX
      Jika pembayaran sudah success di tab lain:
      → countdown berhenti
      → tampilan berubah ke "Pembayaran Berhasil"
--}}
@extends('layouts.app')

@section('title', 'Cek Email Anda | EPT Portal')

@section('content')
<main class="flex-grow flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-[520px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 sm:p-10">

            {{-- ================================================ --}}
            {{-- STATE 1: MENUNGGU VERIFIKASI + COUNTDOWN --}}
            {{-- ================================================ --}}
            <div id="state-waiting">
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

            {{-- ================================================ --}}
            {{-- STATE 2: PEMBAYARAN BERHASIL (ditampilkan via JS) --}}
            {{-- ================================================ --}}
            <div id="state-success" class="hidden">
                <div class="mb-8 text-center">
                    <div class="mx-auto w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-5">
                        <span class="material-symbols-outlined text-green-500 text-4xl">check_circle</span>
                    </div>
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Pembayaran Berhasil! 🎉</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">
                        Pembayaran Anda telah berhasil diverifikasi. Anda sudah terdaftar sebagai peserta EPT.
                    </p>
                </div>

                {{-- Success Info Box --}}
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-green-500 mt-0.5">verified</span>
                        <div>
                            <p class="text-sm text-green-800 dark:text-green-300 leading-relaxed">
                                Anda sudah otomatis login ke sistem. Silakan lanjutkan ke halaman utama.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Action Button --}}
                <a href="{{ route('mahasiswa.ujian.index') }}" 
                   class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">home</span>
                    <span>Ke Halaman Utama</span>
                </a>
            </div>

        </div>
    </div>
</main>

<script>
(function() {
    const countdownEl = document.getElementById('countdown');
    const expiredTextEl = document.getElementById('expired-text');
    const resendSection = document.getElementById('resend-section');
    const stateWaiting = document.getElementById('state-waiting');
    const stateSuccess = document.getElementById('state-success');

    let totalSeconds = 5 * 60; // 5 menit
    let countdownStopped = false;
    const daftarId = '{{ session("verification_daftar_id", "") }}';

    // =============================================
    // COUNTDOWN TIMER
    // =============================================
    function updateTimer() {
        if (countdownStopped) return;

        const minutes = Math.floor(totalSeconds / 60);
        const seconds = totalSeconds % 60;
        countdownEl.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');

        if (totalSeconds <= 0) {
            countdownEl.classList.add('text-red-500');
            expiredTextEl.classList.remove('hidden');
            resendSection.classList.remove('hidden');
            return;
        }

        if (totalSeconds <= 60) {
            countdownEl.classList.remove('text-slate-900', 'dark:text-white');
            countdownEl.classList.add('text-amber-500');
        }

        totalSeconds--;
        setTimeout(updateTimer, 1000);
    }

    // =============================================
    // POLLING: Cek status pembayaran setiap 3 detik
    // Ketika pembayaran berhasil di tab lain,
    // tab ini otomatis mendeteksi dan berubah.
    // =============================================
    function pollPaymentStatus() {
        if (!daftarId || countdownStopped) return;

        fetch('/mahasiswa/verifikasi/cek-status/' + daftarId)
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Pembayaran berhasil! Stop countdown, tampilkan state success
                    countdownStopped = true;
                    stateWaiting.classList.add('hidden');
                    stateSuccess.classList.remove('hidden');
                } else {
                    // Masih pending, cek lagi 3 detik kemudian
                    setTimeout(pollPaymentStatus, 3000);
                }
            })
            .catch(() => {
                // Jika error, coba lagi 5 detik kemudian
                setTimeout(pollPaymentStatus, 5000);
            });
    }

    // Mulai countdown dan polling
    updateTimer();
    setTimeout(pollPaymentStatus, 3000); // Mulai polling setelah 3 detik pertama
})();
</script>
@endsection

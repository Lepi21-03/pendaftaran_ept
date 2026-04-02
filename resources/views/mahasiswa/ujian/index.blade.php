@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-16">
<header class="mb-12">
<h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-4">
                English Proficiency Test
            </h1>
<p class="text-lg text-slate-600 dark:text-slate-400 max-w-2xl leading-relaxed">
                Take your professional journey to the next level. Browse and register for upcoming EPT sessions held by our certified instructors.
            </p>
</header>
<section>
<div class="flex items-center justify-between mb-8">
<div class="flex items-center gap-3">
<span class="material-symbols-outlined text-primary">calendar_month</span>
<h2 class="text-2xl font-bold text-slate-800 dark:text-slate-100">Available Sessions</h2>
</div>

</div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($ujian as $u)
            <div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 rounded-2xl hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 relative overflow-hidden flex flex-col">
                <div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 -mr-8 -mt-8 rounded-full group-hover:scale-110 transition-transform"></div>
                <div class="mb-6">
                        @php
                            $isPast = \Carbon\Carbon::parse($u->tanggal_ujian)->isPast() && !\Carbon\Carbon::parse($u->tanggal_ujian)->isToday();
                            $isFull = $u->sisaKuota() <= 0;
                        @endphp
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 
                        @if($isPast) bg-slate-100 dark:bg-slate-900/40 text-slate-600 dark:text-slate-400
                        @elseif($isFull) bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                        @elseif($u->sisaKuota() > 5) bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                        @else bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 @endif 
                        text-xs font-bold uppercase tracking-wider rounded-full mb-4">
                        <span class="w-1.5 h-1.5 rounded-full 
                            @if($isPast) bg-slate-400
                            @elseif($isFull) bg-red-500
                            @elseif($u->sisaKuota() > 5) bg-green-500 animate-pulse
                            @else bg-amber-500 @endif"></span>
                        @if($isPast)
                            Test Completed
                        @elseif($isFull)
                            Quota Full
                        @elseif($u->sisaKuota() > 5) 
                            Registration Open
                        @else 
                            Filling Fast 
                        @endif
                    </span>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight">EPT {{ \Carbon\Carbon::parse($u->tanggal_ujian)->translatedFormat('d F Y') }}</h3>
                    <div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm font-medium">
                        <span class="material-symbols-outlined text-base">groups</span>
                        Kuota: {{ $u->sisaKuota() }} / {{ $u->kuota }}
                    </div>
                </div>
                <div class="space-y-4 mb-8 flex-grow">
                    <p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
                     <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4 text-slate-500 dark:text-slate-400"
                         viewBox="0 0 24 24"
                          fill="currentColor">
                        <path fill-rule="evenodd"
                       d="M12 2C8.686 2 6 4.686 6 8c0 4.418 6 12 6 12s6-7.582 6-12c0-3.314-2.686-6-6-6zm0 8.5a2.5 2.5 0 110-5 2.5 2.5 0 010 5z"
                              clip-rule="evenodd"/>
                    </svg>
                         <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $u->lokasi ?? 'Lokasi belum ditentukan' }}</span>
                    </p>
                    <div class="space-y-3">
                        @foreach($u->pengawas as $p)
                    <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold text-xs">
                                {{ $p->inisial }}
                            </div>
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">{{ $p->nama }}</span>
                        </div>
                        @endforeach
                        @if($u->pengawas->isEmpty())
                        <p class="text-sm text-slate-400 italic">Belum ada pengawas ditugaskan</p>
                        @endif
                    </div>
                </div>
                <div class="mt-auto">
                    @if(!$isPast && !$isFull)
                        <a href="{{ route('mahasiswa.daftar.index', ['ujian_id' => $u->id]) }}" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                            Register Now
                            <span class="material-symbols-outlined group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
                        </a>
                    @elseif($isPast)
                        <button onclick="showToast('warning','Session Closed','The exam date has passed. This session is completed.')" class="w-full py-3 bg-slate-400 text-white font-bold rounded-xl transition-all shadow-lg flex items-center justify-center gap-2 cursor-not-allowed">
                            <span class="material-symbols-outlined">check_circle</span>
                            Test Completed
                        </button>
                    @else
                        <button onclick="showToast('error','Quota Full','The registration quota is full. Registration is closed.')" class="w-full py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl transition-all shadow-lg shadow-red-500/25 flex items-center justify-center gap-2 cursor-not-allowed">
                            <span class="material-symbols-outlined">lock</span>
                            Quota Full
                        </button>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-span-full group bg-slate-100 dark:bg-slate-800/40 border-2 border-dashed border-slate-300 dark:border-slate-700 p-12 rounded-2xl flex flex-col items-center justify-center text-center gap-4 transition-colors">
                <div class="w-16 h-16 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500">
                    <span class="material-symbols-outlined text-3xl">update</span>
                </div>
                <div>
                    <p class="text-slate-600 dark:text-slate-400 font-semibold text-xl">Belum ada sesi tersedia</p>
                    <p class="text-slate-400 dark:text-slate-500">Jadwal Baru Akan Segera Diumumkan.</p>
                </div>
            </div>
            @endforelse
        </div>
</section>
</main>
@endsection

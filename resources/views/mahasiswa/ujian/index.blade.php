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
<div class="flex items-center gap-2 bg-white dark:bg-slate-800 p-1 rounded-lg border border-slate-200 dark:border-slate-700">
<button class="p-1.5 rounded-md bg-slate-100 dark:bg-slate-700 text-primary">
<span class="material-symbols-outlined block">grid_view</span>
</button>
<button class="p-1.5 rounded-md text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700">
<span class="material-symbols-outlined block">view_list</span>
</button>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 rounded-2xl hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 relative overflow-hidden flex flex-col">
<div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 -mr-8 -mt-8 rounded-full group-hover:scale-110 transition-transform"></div>
<div class="mb-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
<span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Registration Open
                        </span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight">EPT 26 NOVEMBER 2025</h3>
<div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm font-medium">
<span class="material-symbols-outlined text-base">location_on</span>
                            Main Hall, Language Center
                        </div>
</div>
<div class="space-y-4 mb-8 flex-grow">
<p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
<span class="material-symbols-outlined text-sm">school</span>
                            Invigilators &amp; Teachers
                        </p>
<div class="space-y-3">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center text-indigo-700 dark:text-indigo-400 font-bold text-xs">DH</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Dewi Rosnita Hardiany, S.S., M.Li</span>
</div>
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-xs uppercase">AU</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Admin User</span>
</div>
</div>
</div>
<div class="mt-auto">
<a href="{{ route('mahasiswa.daftar') }}" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                            Register Now
                            <span class="material-symbols-outlined group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
</div>
<div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 rounded-2xl hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 relative overflow-hidden flex flex-col">
<div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 -mr-8 -mt-8 rounded-full group-hover:scale-110 transition-transform"></div>
<div class="mb-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
<span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                            Registration Open
                        </span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight">UJIAN EPT 19 NOVEMBER 2025</h3>
<div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm font-medium">
<span class="material-symbols-outlined text-base">location_on</span>
                            Virtual Session (Zoom)
                        </div>
</div>
<div class="space-y-4 mb-8 flex-grow">
<p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
<span class="material-symbols-outlined text-sm">school</span>
                            Invigilators &amp; Teachers
                        </p>
<div class="space-y-3">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-pink-100 dark:bg-pink-900/40 flex items-center justify-center text-pink-700 dark:text-pink-400 font-bold text-xs">BB</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Budiati Budiati</span>
</div>
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-700 dark:text-amber-400 font-bold text-xs">ES</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Endang Susilowati</span>
</div>
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-xs">AU</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Admin User</span>
</div>
</div>
</div>
<div class="mt-auto">
<a href="{{ route('mahasiswa.daftar') }}" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                            Register Now
                            <span class="material-symbols-outlined group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
</div>
<div class="group bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 p-6 rounded-2xl hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-300 relative overflow-hidden flex flex-col">
<div class="absolute top-0 right-0 w-24 h-24 bg-primary/5 -mr-8 -mt-8 rounded-full group-hover:scale-110 transition-transform"></div>
<div class="mb-6">
<span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 text-xs font-bold uppercase tracking-wider rounded-full mb-4">
<span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                            Filling Fast
                        </span>
<h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight">UJIAN EPT 12 NOVEMBER 2025</h3>
<div class="flex items-center gap-2 text-slate-500 dark:text-slate-400 text-sm font-medium">
<span class="material-symbols-outlined text-base">location_on</span>
                            Computer Lab A
                        </div>
</div>
<div class="space-y-4 mb-8 flex-grow">
<p class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest flex items-center gap-2">
<span class="material-symbols-outlined text-sm">school</span>
                            Invigilators &amp; Teachers
                        </p>
<div class="space-y-3">
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-amber-100 dark:bg-amber-900/40 flex items-center justify-center text-amber-700 dark:text-amber-400 font-bold text-xs">ES</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Endang Susilowati</span>
</div>
<div class="flex items-center gap-3">
<div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-bold text-xs uppercase">AU</div>
<span class="text-sm font-medium text-slate-700 dark:text-slate-300">Admin User</span>
</div>
</div>
</div>
<div class="mt-auto">
<a href="{{ route('mahasiswa.daftar') }}" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                            Register Now
                            <span class="material-symbols-outlined group-hover/btn:translate-x-1 transition-transform">arrow_forward</span>
</a>
</div>
</div>
<div class="group bg-slate-100 dark:bg-slate-800/40 border-2 border-dashed border-slate-300 dark:border-slate-700 p-6 rounded-2xl flex flex-col items-center justify-center text-center gap-4 transition-colors">
<div class="w-12 h-12 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-400 dark:text-slate-500">
<span class="material-symbols-outlined">update</span>
</div>
<div>
<p class="text-slate-600 dark:text-slate-400 font-semibold">More Sessions Coming Soon</p>
<p class="text-sm text-slate-400 dark:text-slate-500">New dates are announced every Friday.</p>
</div>
</div>
</div>
</section>
</main>
@endsection

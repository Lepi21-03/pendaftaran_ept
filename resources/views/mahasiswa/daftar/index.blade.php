@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <div class="mb-10 text-center sm:text-left">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">English Proficiency Test</h1>
        <p class="text-slate-500 dark:text-slate-400">Complete the form below to register for your English proficiency certification.</p>
    </div>
    <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
        <div class="p-6 sm:p-10">
            <div class="mb-8 border-b border-slate-100 dark:border-slate-700 pb-4">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Registration Form</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Please ensure all your information is accurate as it will appear on your certificate.</p>
            </div>
            <form action="{{ route('mahasiswa.daftar.store') }}" class="space-y-6" method="POST">
                @csrf
                <input type="hidden" name="ujian_id" value="{{ $ujian->id }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="nim">Student ID (NIM)</label>
                        <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="nim" name="nim" placeholder="Enter your nim" required="" type="text" value="{{ old('nim') }}"/>
                        @error('nim') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="nama_lengkap">Full Name</label>
                        <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="nama_lengkap" name="nama_lengkap" placeholder="Enter your full legal name" required="" type="text" value="{{ old('nama_lengkap') }}"/>
                        @error('nama_lengkap') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="email">Email Address</label>
                        <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="email" name="email" placeholder="yourname@gmail.com" required="" type="email" value="{{ old('email') }}"/>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="no_telp">Phone Number</label>
                        <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="no_telp" name="no_telp" placeholder="081234567890" required="" type="tel" value="{{ old('no_telp') }}"/>
                        @error('no_telp') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="bod">Date of Birth (DOB) </label>
                        <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="bod" name="bod" required="" type="date" value="{{ old('bod') }}"/>
                        @error('bod') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300" for="prodi">Study Program</label>
                        <select id="prodi" name="prodi" class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" required>
                            <option value="" disabled {{ old('prodi') ? '' : 'selected' }}>Select your study program</option>
                            @foreach($prodis as $p)
                                <option value="{{ $p->nama_prodi }}" {{ old('prodi') == $p->nama_prodi ? 'selected' : '' }}>{{ $p->nama_prodi }}</option>
                            @endforeach
                        </select>
                        @error('prodi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-3">
                        <span class="material-icons text-primary mt-0.5">info</span>
                        <div>
                            <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-300">Session Details</h4>
                            <p class="text-sm text-blue-800 dark:text-blue-400">You are registering for: <span class="font-medium">EPT {{ \Carbon\Carbon::parse($ujian->tanggal_ujian)->translatedFormat('d F Y') }}</span></p>
                        </div>
                    </div>
                </div>
                <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400">
                        <span class="material-icons text-lg">lock</span>
                        Secure payment processing
                    </div>
                    <button class="w-full sm:w-auto bg-primary hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg shadow-lg shadow-blue-500/30 transition-all hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2" type="submit">
                        Proceed to Payment
                        <span class="material-icons">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="fixed bottom-6 right-6 z-40">
    <button class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-all active:scale-95">
        <span class="material-icons">help_outline</span>
    </button>
</div>
</div>
@endsection

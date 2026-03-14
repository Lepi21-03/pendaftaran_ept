@extends('layouts.app')

@section('title', 'Reset Password | EPT Portal')

@section('content')
<main class="grow flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-[440px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
        <div class="p-8 sm:p-10">
            <div class="mb-8 text-center">
                <div class="mx-auto w-16 h-16 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-3xl">key</span>
                </div>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-slate-100 mb-2">Reset Password</h1>
                <p class="text-slate-500 dark:text-slate-400 text-sm">Silakan masukkan password baru Anda.</p>
            </div>
            
            <form action="{{ route('mahasiswa.password.update') }}" class="space-y-6" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                @if($errors->any())
                    <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">error</span>
                        {{ $errors->first() }}
                    </div>
                @endif
                
                {{-- Email Field (Readonly) --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block" for="email">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-500 dark:text-slate-400 outline-none transition-all" id="email" name="email" value="{{ $email ?? old('email') }}" readonly required="" type="email"/>
                    </div>
                </div>

                {{-- New Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block" for="password">New Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                        <input class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" id="password" name="password" placeholder="Minimal 8 karakter" required="" type="password"/>
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block" for="password_confirmation">Confirm Password</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">lock_clock</span>
                        <input class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" required="" type="password"/>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                    <span>Reset Password</span>
                    <span class="material-symbols-outlined transition-transform group-hover/btn:translate-x-1">
                        update
                    </span>
                </button>
            </form>
        </div>
    </div>
</main>
@endsection

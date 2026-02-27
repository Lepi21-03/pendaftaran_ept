@extends('layouts.app')

@section('title', 'Login | EPT Portal')

@section('content')
<main class="flex-grow flex items-center justify-center p-6 min-h-[80vh]">
    <div class="w-full max-w-[440px] bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-2xl">
        <div class="p-8 sm:p-10">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-slate-100 mb-2">Welcome Back</h1>
                <p class="text-slate-500 dark:text-slate-400">Please enter your details to sign in.</p>
            </div>
            
            <form action="{{ route('mahasiswa.login.store') }}" class="space-y-6" method="POST">
                @csrf

                @if($errors->any())
                    <div class="p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <!-- Email Field -->
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-slate-700 dark:text-slate-300 block" for="email">Email Address</label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">mail</span>
                        <input class="w-full pl-11 pr-4 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" id="email" name="email" value="{{ old('email') }}" placeholder="yourname@gmail.com" required="" type="email"/>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-semibold text-slate-700 dark:text-slate-300" for="password">Student ID Number (NIM)</label>
                    </div>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute inset-y-0 left-3 flex items-center text-slate-400 group-focus-within:text-primary transition-colors">badge</span>
                        <input class="w-full pl-11 py-3 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all placeholder:text-slate-400" id="password" name="password" placeholder="Enter your 10-digit Student ID" required="" type="text"/>
                    </div>
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full py-3 bg-primary hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 group/btn">
                    <span>Sign In</span>
                    <span class="material-symbols-outlined transition-transform group-hover/btn:translate-x-1">
                        arrow_forward
                    </span>
                </button>
            </form>

    </div>
</main>
@endsection

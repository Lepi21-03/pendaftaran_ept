@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-12">
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Profil Mahasiswa</h1>
        <p class="text-slate-500 dark:text-slate-400">Atur informasi pribadi dan lihat riwayat pendaftaran ujian Anda.</p>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-sm border border-green-200 dark:border-green-800 flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-4 rounded-lg bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 text-sm border border-red-200 dark:border-red-800">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Sidebar Kiri: Info Profil -->
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-xl p-6 flex flex-col items-center text-center">
                @php
                    $words = explode(' ', $user->name);
                    $initials = count($words) >= 2 
                        ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                        : strtoupper(substr($words[0], 0, 1));
                @endphp
                <div class="w-24 h-24 rounded-full bg-primary/10 text-primary flex items-center justify-center text-3xl font-bold mb-4">
                    {{ $initials }}
                </div>
                <h2 class="text-xl font-bold text-slate-900 dark:text-white">{{ $user->name }}</h2>
                <p class="text-slate-500 dark:text-slate-400 text-sm">{{ $user->email }}</p>
                
                <div class="mt-6 w-full pt-6 border-t border-slate-100 dark:border-slate-700">
                    <div class="flex justify-between items-center text-sm mb-3">
                        <span class="text-slate-500 dark:text-slate-400">NIM</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $user->nim }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm mb-3">
                        <span class="text-slate-500 dark:text-slate-400">Program Studi</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $user->prodi ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-slate-500 dark:text-slate-400">No. Telp</span>
                        <span class="font-medium text-slate-900 dark:text-white">{{ $user->phone ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Ganti Password Card -->
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-xl p-6">
                <h3 class="font-semibold text-slate-900 dark:text-white mb-2">Keamanan</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Gunakan fitur ini jika Anda ingin melakukan reset atau perubahan pada password Anda.</p>
                <a href="{{ route('mahasiswa.profile.change-password') }}" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                    <span class="material-symbols-outlined text-[20px]">lock_reset</span>
                    Perbarui Password
                </a>
            </div>
        </div>

        <!-- Kolom Kanan: Form Edit & Riwayat Ujian -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Edit Biodata -->
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-xl p-6 sm:p-8">
                <div class="mb-6 border-b border-slate-100 dark:border-slate-700 pb-4">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Edit Profil Dasar</h2>
                </div>

                <form action="{{ route('mahasiswa.profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="name">Nama Lengkap</label>
                            <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required/>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1" for="email">Alamat Email</label>
                            <input class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-900 text-slate-900 dark:text-white focus:ring-2 focus:ring-primary focus:border-transparent transition-all outline-none" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required/>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Pemberitahuan ujian dan pembayaran akan dikirimkan ke email ini.</p>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-primary hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow shadow-blue-500/25 transition-all text-sm">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            <!-- Riwayat Pendaftaran Ujian -->
            <div class="bg-white dark:bg-slate-800 shadow-sm border border-slate-200 dark:border-slate-700 rounded-xl overflow-hidden">
                <div class="p-6 border-b border-slate-100 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-200">Riwayat Ujian</h2>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500 dark:text-slate-400">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 dark:bg-slate-800 dark:text-slate-400 border-b border-slate-200 dark:border-slate-700">
                            <tr>
                                <th scope="col" class="px-6 py-4">Tanggal Ujian</th>
                                <th scope="col" class="px-6 py-4">Lokasi</th>
                                <th scope="col" class="px-6 py-4">Status Pendaftaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->daftars as $daftar)
                                <tr class="bg-white dark:bg-slate-900 border-b dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50">
                                    <td class="px-6 py-4 font-medium text-slate-900 dark:text-white whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($daftar->ujian->tanggal_ujian ?? '')->translatedFormat('d F Y') }} <br>
                                        <span class="text-xs text-slate-500">{{ $daftar->ujian->jam_mulai ?? '' }} - {{ $daftar->ujian->jam_selesai ?? '' }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $daftar->ujian->lokasi ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($daftar->status == 'pending')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-yellow-300">Menunggu Pembayaran</span>
                                        @elseif($daftar->status == 'success')
                                            <span class="bg-green-100 text-green-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-green-300">Terdaftar</span>
                                        @else
                                            <span class="bg-slate-100 text-slate-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded border border-slate-300">{{ ucfirst($daftar->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-8 text-center text-slate-500 dark:text-slate-400">
                                        Belum ada riwayat pendaftaran ujian.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

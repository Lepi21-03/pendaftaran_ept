@extends('layouts.app')

@section('content')
<div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
            <h1 class="text-4xl font-bold text-gray-700 dark:text-gray-200">
                Selamat Datang di Pendaftaran EPT
            </h1>
        </div>

        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg p-6">
            <p class="text-lg text-gray-600 dark:text-gray-400">
                Ini adalah halaman utama menggunakan layout baru.
            </p>
            <div class="mt-6">
                <a href="#" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-500 transition">
                    Mulai Pendaftaran
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

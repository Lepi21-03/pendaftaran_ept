<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EPT'))</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#2563eb",
                        "background-light": "#f8fafc",
                        "background-dark": "#0f172a",
                    },
                    fontFamily: {
                        sans: ["Plus Jakarta Sans", "sans-serif"],
                    },
                },
            },
        };
    </script>

    <style>
        /* Memastikan font diterapkan ke seluruh elemen */
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }

        /* CSS khusus agar Ikon Outlined muncul dengan benar */
        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined' !important;
            font-weight: normal;
            font-style: normal;
            font-size: 24px;
            line-height: 1;
            letter-spacing: normal;
            text-transform: none;
            display: inline-block;
            white-space: nowrap;
            word-wrap: normal;
            direction: ltr;
            -webkit-font-feature-settings: 'liga';
            -webkit-font-smoothing: antialiased;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen flex flex-col transition-colors duration-200">

    {{-- NAVBAR --}}
    @include('layouts.navbar')

    {{-- MAIN CONTENT --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    @include('layouts.footer')



</body>
</html>

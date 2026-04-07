<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Pendaftaran EPT'))</title>

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

        /* LIGHT MODE */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #ffffff inset !important;
            -webkit-text-fill-color: #0f172a !important;
        }

        /* DARK MODE */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover,
        .dark input:-webkit-autofill:focus {
            -webkit-box-shadow: 0 0 0px 1000px #1e293b inset !important;
            -webkit-text-fill-color: #ffffff !important;
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

    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

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



    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showToast(icon, title, text) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                position: 'top',
                toast: true,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-toast-custom'
        }
    });
}
</script>

    {{-- Notifikasi Popup Modern (Session Flash) --}}
    @if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: @json(session('success')),
                position: 'top',
                toast: true,
                showConfirmButton: false,
                timer: 10000,
                timerProgressBar: true,
                customClass: {
                    popup: 'swal-toast-custom'
                },
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        });
    </script>
    @endif

    @if(session('error'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: @json(session('error')),
                position: 'top',
                toast: true,
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });
        });
    </script>
    @endif

    <style>
        /* SweetAlert2 Toast Custom Styling */
        .swal2-popup.swal2-toast {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
            border-radius: 12px !important;
            background-color: #f8fafc !important;
            color: #0f172a !important;
            border: 1px solid #e2e8f0 !important;
        }
        .swal2-popup.swal2-toast .swal2-title {
            color: #0f172a !important;
        }
        .swal2-popup.swal2-toast .swal2-html-container {
            color: #475569 !important;
        }

        /* Dark mode */
        .dark .swal2-popup.swal2-toast {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
            border: 1px solid #1e293b !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4) !important;
        }
        .dark .swal2-popup.swal2-toast .swal2-title {
            color: #f1f5f9 !important;
        }
        .dark .swal2-popup.swal2-toast .swal2-html-container {
            color: #94a3b8 !important;
        }
    </style>

</body>
</html>

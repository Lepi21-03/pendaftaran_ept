<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'EPT - Available Test Sessions')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
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
              display: ["Plus Jakarta Sans", "sans-serif"],
            },
            borderRadius: {
              DEFAULT: "0.75rem",
            },
          },
        },
      };
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        .glass-nav {
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
        }
    </style>
</head>
<body class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 min-h-screen transition-colors duration-200 flex flex-col">
    @include('layouts.navbar')

    <div class="flex-grow">
        @yield('content')
    </div>

    <button
  class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-white rounded-full flex items-center justify-center shadow-lg hover:bg-blue-700 transition-all active:scale-95 z-40"
  title="Help">
  <span class="material-symbols-outlined">help</span>
</button>


    @include('layouts.footer')
</body>
</html>

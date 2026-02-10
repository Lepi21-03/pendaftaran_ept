<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aplikasi Pendaftaran EPT')</title>
    <style>
        /* Variabel CSS untuk kemudahan pengelolaan warna */
        :root {
            --primary-color: #3498db; /* Biru cerah */
            --secondary-color: #2c3e50; /* Biru gelap untuk teks/footer */
            --accent-color: #e74c3c; /* Merah untuk aksen jika perlu */
            --background-color: #f4f6f7; /* Abu-abu sangat muda */
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Reset CSS dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--background-color);
            color: var(--secondary-color);
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Agar footer selalu di bawah */
            line-height: 1.6;
        }

        /* Styling Navbar */
        nav {
            background-color: var(--white);
            box-shadow: var(--shadow);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky; /* Navbar tetap di atas saat scroll */
            top: 0;
            z-index: 1000;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
            letter-spacing: 1px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--secondary-color);
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary-color);
        }

        /* Styling Main Content */
        main {
            flex: 1; /* Mengisi ruang kosong agar footer terdorong ke bawah */
            padding: 2rem;
            width: 100%;
            max-width: 1200px; /* Membatasi lebar konten agar rapi */
            margin: 0 auto; /* Tengah secara horizontal */
        }

        /* Styling Footer */
        footer {
            background-color: var(--secondary-color);
            color: var(--white);
            text-align: center;
            padding: 1.5rem;
            margin-top: auto;
            font-size: 0.9rem;
        }

        /* Responsiveness (Tampilan Mobile) */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                padding: 1rem;
            }

            .logo {
                margin-bottom: 1rem;
            }

            .nav-links {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                width: 100%;
            }
            
            .nav-links li {
                width: 100%;
            }

            .nav-links a {
                display: block;
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Bagian Navbar -->
    <nav>
        <a href="{{ url('/') }}" class="logo">Pendaftaran EPT</a>
        <ul class="nav-links">
            <li><a href="{{ url('/') }}">Beranda</a></li>
            <li><a href="#">Jadwal</a></li>
            <li><a href="#">Pendaftaran</a></li>
            <li><a href="#">Kontak</a></li>
        </ul>
    </nav>

    <!-- Bagian Konten Utama -->
    <main>
        <!-- Area konten utama -->
        @yield('content')
    </main>

    <!-- Bagian Footer -->
    <footer>
        <p>&copy; {{ date('Y') }} Sistem Pendaftaran EPT. All rights reserved.</p>
    </footer>
</body>
</html>

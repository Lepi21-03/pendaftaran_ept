<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 border-b border-slate-200 dark:border-slate-800 glass-nav">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="flex items-center justify-between h-16">

      <!-- LEFT: Logo + Menu -->
      <div class="flex items-center gap-8">

        <span class="text-2xl font-bold text-primary tracking-tight">EPT</span>

        <!-- Menu -->
        <div class="hidden md:flex items-center gap-6">
          <a href="{{ route('mahasiswa.ujian.index') }}"
             class="text-sm font-semibold {{ request()->routeIs('mahasiswa.ujian.index') ? 'text-primary border-b-2 border-primary' : 'text-slate-600 dark:text-slate-400 hover:text-primary transition-colors' }}">
            Home
          </a>

          @auth('mahasiswa')
          <a href="{{ route('mahasiswa.dokumen') }}"
             class="text-sm font-medium {{ request()->routeIs('mahasiswa.dokumen') ? 'text-primary border-b-2 border-primary' : 'text-slate-600 dark:text-slate-400 hover:text-primary dark:hover:text-white transition-colors' }}">
            Documents
          </a>
          @endauth
        </div>

      </div>

      <!-- RIGHT: Dark mode + Login -->
      <div class="flex items-center gap-4">
        <button
          id="theme-toggle"
          class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors"
        >
          <span class="material-symbols-outlined block dark:hidden">dark_mode</span>
          <span class="material-symbols-outlined hidden dark:block">light_mode</span>
        </button>

        <script>
          const themeToggleBtn = document.getElementById('theme-toggle');
          
          themeToggleBtn.addEventListener('click', function() {
              // if set via local storage previously
              if (localStorage.getItem('theme')) {
                  if (localStorage.getItem('theme') === 'light') {
                      document.documentElement.classList.add('dark');
                      localStorage.setItem('theme', 'dark');
                  } else {
                      document.documentElement.classList.remove('dark');
                      localStorage.setItem('theme', 'light');
                  }
      
              // if NOT set via local storage previously
              } else {
                  if (document.documentElement.classList.contains('dark')) {
                      document.documentElement.classList.remove('dark');
                      localStorage.setItem('theme', 'light');
                  } else {
                      document.documentElement.classList.add('dark');
                      localStorage.setItem('theme', 'dark');
                  }
              }
          });
        </script>

        @guest('mahasiswa')
         <a class="text-slate-600 dark:text-slate-300 hover:text-primary text-sm font-medium" href="{{ route('mahasiswa.login') }}">Log in</a>
        @endguest

        @auth('mahasiswa')
        <form action="{{ route('mahasiswa.logout') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="text-slate-600 dark:text-slate-300 hover:text-danger text-sm font-medium">Log out</button>
        </form>
        @endauth
      </div>

    </div>
  </div>
</nav>

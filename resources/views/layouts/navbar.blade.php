<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 border-b border-slate-200 dark:border-slate-800 glass-nav backdrop-blur-sm">
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
        <div class="relative" id="profile-dropdown-container">
            @php
                $user = \Illuminate\Support\Facades\Auth::guard('mahasiswa')->user();
                $words = explode(' ', $user->name);
                $initials = count($words) >= 2 
                    ? strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1))
                    : strtoupper(substr($words[0], 0, 1));
            @endphp
            <button id="profile-btn" class="flex items-center justify-center w-9 h-9 rounded-full bg-primary/10 text-primary text-sm font-bold border border-primary/20 hover:scale-105 transition-all focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 dark:focus:ring-offset-slate-900 shadow-sm ml-2">
                {{ $initials }}
            </button>

            <!-- Dropdown Menu -->
            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-[0_10px_40px_-10px_rgba(0,0,0,0.1)] border border-slate-200 dark:border-slate-700 py-1 z-50 overflow-hidden origin-top-right transform transition-all duration-200 opacity-0 scale-95">
                <a href="{{ route('mahasiswa.profile') }}" class="block px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">person</span> Profil
                </a>
                
                <div class="border-t border-slate-100 dark:border-slate-700 my-1"></div>
                
                <form action="{{ route('mahasiswa.logout') }}" method="POST" class="block w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/10 flex items-center gap-2 transition-colors">
                        <span class="material-symbols-outlined text-[18px]">logout</span> Keluar
                    </button>
                </form>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const profileBtn = document.getElementById('profile-btn');
                const profileMenu = document.getElementById('profile-menu');
                let isMenuOpen = false;

                if(profileBtn && profileMenu) {
                    profileBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        isMenuOpen = !isMenuOpen;
                        
                        if(isMenuOpen) {
                            profileMenu.classList.remove('hidden');
                            setTimeout(() => {
                                profileMenu.classList.remove('opacity-0', 'scale-95');
                                profileMenu.classList.add('opacity-100', 'scale-100');
                            }, 10);
                        } else {
                            profileMenu.classList.remove('opacity-100', 'scale-100');
                            profileMenu.classList.add('opacity-0', 'scale-95');
                            setTimeout(() => {
                                profileMenu.classList.add('hidden');
                            }, 200);
                        }
                    });

                    document.addEventListener('click', function(e) {
                        if (isMenuOpen && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                            isMenuOpen = false;
                            profileMenu.classList.remove('opacity-100', 'scale-100');
                            profileMenu.classList.add('opacity-0', 'scale-95');
                            setTimeout(() => {
                                profileMenu.classList.add('hidden');
                            }, 200);
                        }
                    });
                }
            });
        </script>
        @endauth
      </div>

    </div>
  </div>
</nav>

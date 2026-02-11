<header class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-8">
                <div class="flex items-center">
                    <span class="text-2xl font-bold text-primary tracking-tight">EPT</span>
                </div>
                <nav class="hidden md:flex space-x-8">
                    <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-primary transition-all" href="/">Home</a>
                    <a class="text-primary border-b-2 border-primary px-3 py-2 text-sm font-medium" href="{{ route('mahasiswa.daftar') }}">Registration</a>
                    <a class="text-slate-600 dark:text-slate-300 hover:text-primary dark:hover:text-primary px-3 py-2 text-sm font-medium border-b-2 border-transparent hover:border-primary transition-all" href="#">My Certificate</a>
                </nav>
            </div>
            <div class="flex items-center gap-4">
                <button class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 dark:text-slate-400" onclick="toggleDarkMode()">
                    <span class="material-icons text-xl dark:hidden">dark_mode</span>
                    <span class="material-icons text-xl hidden dark:block">light_mode</span>
                </button>
                <a class="text-slate-600 dark:text-slate-300 hover:text-primary text-sm font-medium" href="#">Log in</a>
            </div>
        </div>
    </div>
</header>

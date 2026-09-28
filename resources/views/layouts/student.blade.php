<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Siswa - Seleksi OSIS')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="min-h-full flex overflow-x-hidden antialiased selection:bg-emerald-600 selection:text-white">

    <!-- Mobile Backdrop Overlay -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar (Responsive Drawer for Mobile, Fixed Sidebar for Desktop) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col justify-between p-6 shadow-xl transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shrink-0 border-r border-slate-800">
        <div>
            <!-- Logo & Brand -->
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-800/80">
                <div class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Hijau Muda" class="h-9 w-auto object-contain">
                    <div>
                        <h2 class="text-xs font-extrabold text-white tracking-wider leading-none">PORTAL SISWA</h2>
                        <p class="text-[10px] font-bold text-emerald-500 tracking-wide mt-1 uppercase">SMK Hijau Muda</p>
                    </div>
                </div>
                <!-- Close Button for Mobile -->
                <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <nav class="space-y-1.5">
                <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3 py-3 px-4 rounded-2xl font-semibold text-sm transition {{ request()->routeIs('student.dashboard') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/25' : 'hover:bg-slate-800/80 text-slate-400 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard & Timeline</span>
                </a>
                <a href="{{ route('student.exams') }}" class="flex items-center space-x-3 py-3 px-4 rounded-2xl font-semibold text-sm transition {{ request()->routeIs('student.exams', 'student.exam.room') ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/25' : 'hover:bg-slate-800/80 text-slate-400 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    <span>Ujian Seleksi (CAT)</span>
                </a>
            </nav>
        </div>

        <!-- Logout Section -->
        <div class="pt-4 border-t border-slate-800/80">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-3 px-4 rounded-2xl text-red-400 hover:bg-red-500/10 hover:text-red-300 font-semibold text-sm transition flex items-center space-x-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col min-h-screen overflow-y-auto bg-slate-50">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-slate-200/80 h-20 px-6 md:px-10 flex items-center justify-between shadow-xs shrink-0 sticky top-0 z-30">
            <div class="flex items-center space-x-4">
                <!-- Mobile Hamburger Toggle -->
                <button id="sidebar-toggle" class="md:hidden text-slate-600 hover:text-slate-900 focus:outline-none p-2 rounded-xl bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">@yield('header-title', 'Dashboard Siswa')</h1>
                    <p class="text-xs font-medium text-slate-500 hidden sm:block">Sistem Computer Assisted Test (CAT) Seleksi Anggota OSIS</p>
                </div>
            </div>

            <!-- Student Profile Badge -->
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                    <p class="text-[11px] text-emerald-600 font-bold">NIS: {{ auth()->user()->username }}</p>
                </div>
                <div class="h-10 w-10 bg-emerald-50 text-emerald-700 font-black rounded-2xl flex items-center justify-center text-sm shadow-inner border border-emerald-100">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <main class="flex-1 p-6 md:p-10">
            <div class="max-w-4xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Script Mobile Sidebar Interaction -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarClose = document.getElementById('sidebar-close');
        const sidebarBackdrop = document.getElementById('sidebar-backdrop');

        function toggleSidebar() {
            sidebar.classList.toggle('-translate-x-full');
            sidebarBackdrop.classList.toggle('hidden');
        }

        sidebarToggle.addEventListener('click', toggleSidebar);
        sidebarClose.addEventListener('click', toggleSidebar);
        sidebarBackdrop.addEventListener('click', toggleSidebar);
    </script>
</body>
</html>
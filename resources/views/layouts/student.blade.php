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
<body class="h-full flex overflow-hidden antialiased">

    <!-- Mobile Backdrop Overlay -->
    <div id="sidebar-backdrop" class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden transition-opacity"></div>

    <!-- Sidebar (Responsive Drawer for Mobile, Fixed Sidebar for Desktop) -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-300 flex flex-col justify-between p-6 shadow-xl transform -translate-x-full md:translate-x-0 md:static md:inset-auto transition-transform duration-300 ease-in-out shrink-0">
        <div>
            <!-- Logo & Brand -->
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center space-x-3">
                    <div class="bg-blue-600 text-white font-black p-2.5 rounded-2xl text-lg shadow-lg shadow-blue-600/30">OSIS</div>
                    <div>
                        <h2 class="text-base font-extrabold text-white tracking-wider leading-none">PORTAL SISWA</h2>
                        <p class="text-[11px] font-semibold text-blue-400 tracking-wide mt-1">SELEKSI CAT OSIS</p>
                    </div>
                </div>
                <!-- Close Button for Mobile -->
                <button id="sidebar-close" class="md:hidden text-slate-400 hover:text-white p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <!-- Navigation Links -->
            <nav class="space-y-1.5">
                <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-3 py-3 px-4 rounded-2xl font-semibold text-sm transition {{ request()->routeIs('student.dashboard') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                    <span>🏠</span>
                    <span>Dashboard & Timeline</span>
                </a>
                <a href="{{ route('student.exams') }}" class="flex items-center space-x-3 py-3 px-4 rounded-2xl font-semibold text-sm transition {{ request()->routeIs('student.exams', 'student.exam.room') ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/25' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                    <span>📝</span>
                    <span>Ujian Seleksi (CAT)</span>
                </a>
            </nav>
        </div>

        <!-- Logout Section -->
        <div class="pt-4 border-t border-slate-800/80">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left py-3 px-4 rounded-2xl text-red-400 hover:bg-red-500/10 hover:text-red-300 font-semibold text-sm transition flex items-center space-x-3">
                    <span>🚪</span>
                    <span>Keluar Akun</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-slate-50">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-slate-200/80 h-20 px-6 md:px-10 flex items-center justify-between shadow-sm shrink-0">
            <div class="flex items-center space-x-4">
                <!-- Mobile Hamburger Toggle -->
                <button id="sidebar-toggle" class="md:hidden text-slate-600 hover:text-slate-900 focus:outline-none p-2 rounded-xl bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div>
                    <h1 class="text-lg md:text-xl font-extrabold text-slate-900 tracking-tight">@yield('title', 'Dashboard Siswa')</h1>
                    <p class="text-xs font-medium text-slate-500 hidden sm:block">Sistem Computer Assisted Test (CAT) Seleksi Anggota OSIS</p>
                </div>
            </div>

            <!-- Student Profile Badge -->
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">NIS: {{ auth()->user()->username }}</p>
                </div>
                <div class="h-10 w-10 bg-blue-100 text-blue-700 font-black rounded-2xl flex items-center justify-center text-sm shadow-inner">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <main class="flex-1 p-6 md:p-10 overflow-y-auto">
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
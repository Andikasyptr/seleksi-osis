<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleksi Penerimaan Calon Anggota OSIS - SMK Hijau Muda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-emerald-600 selection:text-white">

    <!-- Navbar Responsive -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Logo Custom -->
            <div class="flex items-center space-x-3.5">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Hijau Muda" class="h-10 w-auto object-contain">
                <div>
                    <h1 class="text-xs md:text-sm font-extrabold tracking-tight text-slate-900 leading-tight">SMK HIJAU MUDA</h1>
                    <p class="text-[11px] font-bold text-emerald-600 tracking-wide uppercase">Portal Seleksi CAT OSIS</p>
                </div>
            </div>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="#fitur" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Keunggulan</a>
                <a href="#alur" class="text-sm font-semibold text-slate-600 hover:text-emerald-600 transition">Tahapan Seleksi</a>
                <a href="{{ route('login') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold px-6 py-3 rounded-2xl shadow-md shadow-emerald-600/20 transition duration-200 flex items-center space-x-2">
                    <span>Masuk Portal</span>
                    <span>→</span>
                </a>
            </div>

            <!-- Mobile Hamburger Button -->
            <div class="md:hidden">
                <button id="menu-btn" class="text-slate-700 focus:outline-none p-2 rounded-xl bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-200 px-6 py-5 space-y-4 shadow-xl">
            <a href="#fitur" class="block text-sm font-semibold text-slate-600 hover:text-emerald-600">Keunggulan Sistem</a>
            <a href="#alur" class="block text-sm font-semibold text-slate-600 hover:text-emerald-600">Tahapan Seleksi</a>
            <a href="{{ route('login') }}" class="block text-center bg-emerald-600 text-white text-sm font-bold py-3.5 rounded-2xl shadow-md shadow-emerald-600/20">Masuk Portal Ujian</a>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="pt-32 pb-20 md:pt-44 md:pb-32 px-6 overflow-hidden">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div class="space-y-6 text-center md:text-left">
                <span class="inline-flex items-center space-x-2.5 bg-emerald-50 border border-emerald-200/80 text-emerald-700 text-xs font-bold px-4 py-2 rounded-full">
                    <span class="h-2 w-2 rounded-full bg-emerald-600 animate-pulse"></span>
                    <span>Penerimaan Pengurus OSIS SMK Hijau Muda</span>
                </span>
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight leading-tight">
                    Seleksi Pengurus <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-600">OSIS Berbasis CAT</span>
                </h1>
                <p class="text-slate-600 text-base md:text-lg max-w-xl mx-auto md:mx-0 leading-relaxed font-medium">
                    Platform Computer Assisted Test resmi SMK Hijau Muda untuk menyaring kader pemimpin muda yang berintegritas, transparan, dan kompeten.
                </p>
                <div class="flex flex-col sm:flex-row items-center justify-center md:justify-start gap-4 pt-2">
                    <a href="{{ route('login') }}" class="w-full sm:w-auto bg-emerald-600 hover:bg-emerald-700 text-white text-base font-bold px-8 py-4 rounded-2xl shadow-xl shadow-emerald-600/25 transition duration-200 text-center flex items-center justify-center space-x-2">
                        <span>Mulai Ujian Seleksi</span>
                        <span>🚀</span>
                    </a>
                    <a href="#alur" class="w-full sm:w-auto bg-white hover:bg-slate-100 text-slate-700 border border-slate-300 text-base font-bold px-8 py-4 rounded-2xl transition duration-200 text-center">
                        Pelajari Alur
                    </a>
                </div>
            </div>

            <!-- Hero Illustration Card -->
            <div class="relative">
                <div class="absolute -inset-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 rounded-3xl blur-2xl opacity-15 animate-pulse"></div>
                <div class="relative bg-white p-8 md:p-10 rounded-3xl border border-slate-200/80 shadow-2xl space-y-6">
                    <div class="flex items-center justify-between pb-6 border-b border-slate-100">
                        <div class="flex items-center space-x-3.5">
                            <div class="h-12 w-12 bg-emerald-50 text-emerald-600 font-bold rounded-2xl flex items-center justify-center text-xl shadow-inner">🏫</div>
                            <div>
                                <h4 class="font-extrabold text-slate-900 text-sm">SMK Hijau Muda</h4>
                                <p class="text-xs text-slate-500 font-medium">Official Assessment System</p>
                            </div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-800 text-xs font-extrabold px-3.5 py-1.5 rounded-full">Sesi Aktif</span>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between text-sm p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-600 font-semibold">Ujian Akademik & Organisasi</span>
                            <span class="font-bold text-slate-900">Pilihan Ganda</span>
                        </div>
                        <div class="flex items-center justify-between text-sm p-4 rounded-2xl bg-slate-50 border border-slate-100">
                            <span class="text-slate-600 font-semibold">Transparansi Kelulusan</span>
                            <span class="font-bold text-emerald-600 flex items-center space-x-1">
                                <span>Real-Time Check</span>
                            </span>
                        </div>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50/80 border border-emerald-200/60 text-emerald-900 text-xs font-semibold text-center leading-relaxed">
                        ✨ Silakan login menggunakan akun NIS/Username yang telah divalidasi oleh panitia OSIS.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Unggulan Section -->
    <section id="fitur" class="py-24 bg-white border-y border-slate-200/80 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest mb-2">KEUNGGULAN PLATFORM</h2>
                <h3 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Seleksi Modern, Adil & Akuntabel</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-bold text-2xl mb-6 shadow-lg shadow-emerald-600/20 group-hover:scale-110 transition">🎯</div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-2">Penilaian Terbobot</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Setiap opsi jawaban memiliki bobot poin tersendiri, menjamin penilaian karakter dan wawasan yang sangat objektif.</p>
                </div>
                <!-- Card 2 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-teal-400 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="h-14 w-14 rounded-2xl bg-teal-600 text-white flex items-center justify-center font-bold text-2xl mb-6 shadow-lg shadow-teal-600/20 group-hover:scale-110 transition">⚡</div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-2">Sistem CAT Interaktif</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Navigasi soal yang intuitif dengan indikator warna status pengerjaan, menghadirkan pengalaman ujian layaknya seleksi nasional.</p>
                </div>
                <!-- Card 3 -->
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-200 hover:border-emerald-400 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div class="h-14 w-14 rounded-2xl bg-emerald-700 text-white flex items-center justify-center font-bold text-2xl mb-6 shadow-lg shadow-emerald-700/20 group-hover:scale-110 transition">📢</div>
                    <h4 class="text-xl font-extrabold text-slate-900 mb-2">Pengumuman Terpusat</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Kandidat dapat langsung memantau status kelulusan akhir secara privat melalui akun masing-masing dengan sekali klik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Alur Seleksi Section -->
    <section id="alur" class="py-24 px-6 bg-slate-50">
        <div class="max-w-5xl mx-auto">
            <div class="text-center max-w-2xl mx-auto mb-16">
                <h2 class="text-xs font-extrabold text-emerald-600 uppercase tracking-widest mb-2">TAHAPAN SELEKSI</h2>
                <h3 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">Langkah Mudah Mengikuti Ujian</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm relative pt-10">
                    <div class="absolute -top-4 left-8 bg-emerald-600 text-white font-black h-9 w-9 rounded-2xl flex items-center justify-center text-sm shadow-md shadow-emerald-600/20">01</div>
                    <h4 class="text-lg font-extrabold text-slate-900 mb-2">Login ke Akun Siswa</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Gunakan NIS atau username dan password resmi yang telah dibagikan oleh panitia seleksi OSIS.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm relative pt-10">
                    <div class="absolute -top-4 left-8 bg-emerald-600 text-white font-black h-9 w-9 rounded-2xl flex items-center justify-center text-sm shadow-md shadow-emerald-600/20">02</div>
                    <h4 class="text-lg font-extrabold text-slate-900 mb-2">Kerjakan Soal CAT</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Pilih jadwal ujian aktif, baca instruksi dengan teliti, dan selesaikan seluruh butir soal pilihan ganda.</p>
                </div>
                <div class="bg-white p-8 rounded-3xl border border-slate-200/80 shadow-sm relative pt-10">
                    <div class="absolute -top-4 left-8 bg-emerald-600 text-white font-black h-9 w-9 rounded-2xl flex items-center justify-center text-sm shadow-md shadow-emerald-600/20">03</div>
                    <h4 class="text-lg font-extrabold text-slate-900 mb-2">Pantau Status Kelulusan</h4>
                    <p class="text-slate-600 text-sm leading-relaxed font-medium">Hasil rekap nilai akhir dan keputusan lolos seleksi dapat dilihat langsung melalui sistem.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 px-6 border-t border-slate-800">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-left">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo SMK Hijau Muda" class="h-8 w-auto object-contain">
                <span class="text-white font-bold text-sm tracking-wide">SMK Hijau Muda</span>
            </div>
            
            <div class="space-y-1">
                <p class="text-xs text-slate-500 font-medium">&copy; {{ date('Y') }} Panitia Seleksi OSIS SMK Hijau Muda. All rights reserved.</p>
                <p class="text-xs text-slate-400 font-medium">
                    Developed with ❤️ by 
                    <a href="https://web-portofolio-me.netlify.app" target="_blank" class="text-emerald-400 hover:text-emerald-300 font-bold underline underline-offset-2 transition">
                        Muhammad Andika Anjas Syaputra, S.Kom.
                    </a>
                </p>
            </div>

            <div class="flex items-center space-x-5 text-xs font-bold text-slate-300">
                <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login Portal</a>
            </div>
        </div>
    </footer>

    <!-- Script Mobile Menu Toggle -->
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
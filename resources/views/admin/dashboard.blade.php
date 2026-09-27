@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('header-title', 'Dashboard Administrator')

@section('content')
    <div class="space-y-8">
        
        <!-- Welcome Banner Card -->
        <div class="bg-gradient-to-r from-emerald-600 to-teal-700 text-white p-8 rounded-3xl shadow-xl shadow-emerald-600/15 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 relative overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            <div class="space-y-2 relative z-10">
                <span class="bg-emerald-500/40 text-white text-xs font-bold px-3.5 py-1.5 rounded-full backdrop-blur-sm">
                    ✨ Sistem CAT Seleksi OSIS
                </span>
                <h2 class="text-2xl md:text-3xl font-black tracking-tight">Selamat Datang, {{ auth()->user()->name }}!</h2>
                <p class="text-emerald-100 text-sm max-w-xl font-medium leading-relaxed">
                    Panel kontrol utama administrasi SMK Hijau Muda. Pantau data siswa terdaftar, kelola jadwal ujian, dan tentukan hasil kelulusan secara real-time.
                </p>
            </div>
            <div class="flex items-center space-x-3 relative z-10 shrink-0">
                <a href="{{ route('admin.exams') }}" class="bg-white text-emerald-800 hover:bg-emerald-50 font-extrabold px-6 py-3.5 rounded-2xl text-xs transition shadow-lg shadow-black/5">
                    + Kelola Ujian
                </a>
            </div>
        </div>

        <!-- Statistik Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <!-- Card Total Siswa -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 flex items-center justify-between group hover:border-emerald-300 transition-all duration-300">
                <div class="space-y-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Siswa Terdaftar</p>
                    <h3 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $totalStudents }}</h3>
                    <p class="text-[11px] text-emerald-600 font-bold flex items-center space-x-1">
                        <span>👥 Akun siap ujian</span>
                    </p>
                </div>
                <div class="h-14 w-14 bg-emerald-50 text-emerald-600 font-bold rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition shadow-inner">
                    🎓
                </div>
            </div>

            <!-- Card Total Ujian -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 flex items-center justify-between group hover:border-teal-300 transition-all duration-300">
                <div class="space-y-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Jadwal Ujian Aktif</p>
                    <h3 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight">{{ $totalExams }}</h3>
                    <p class="text-[11px] text-teal-600 font-bold flex items-center space-x-1">
                        <span>📝 Sesi CAT tersedia</span>
                    </p>
                </div>
                <div class="h-14 w-14 bg-teal-50 text-teal-600 font-bold rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition shadow-inner">
                    ⚡
                </div>
            </div>

            <!-- Card Shortcut Rekap -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 flex items-center justify-between group hover:border-blue-300 transition-all duration-300 sm:col-span-2 lg:col-span-1">
                <div class="space-y-2">
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Rekap & Kelulusan</p>
                    <h3 class="text-base font-extrabold text-slate-800">Evaluasi Hasil Akhir</h3>
                    <a href="{{ route('admin.results') }}" class="inline-flex items-center space-x-1 text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        <span>Buka Rekap Nilai</span>
                        <span>→</span>
                    </a>
                </div>
                <div class="h-14 w-14 bg-blue-50 text-blue-600 font-bold rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition shadow-inner">
                    🏆
                </div>
            </div>

        </div>

    </div>
@endsection
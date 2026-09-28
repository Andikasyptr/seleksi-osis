@extends('layouts.student')

@section('title', 'Dashboard Siswa - Seleksi OSIS')
@section('header-title', 'Dashboard & Timeline')

@section('content')
    <!-- Banner Pengumuman Kelulusan -->
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xs border border-slate-200/80 mb-8 transition hover:shadow-md">
        <div class="flex items-center space-x-3 mb-4">
            <div class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center font-bold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.987 3.987 0 01-1.564-.317z"></path></svg>
            </div>
            <div>
                <h3 class="font-extrabold text-lg text-slate-900">Pengumuman Hasil Seleksi Calon OSIS</h3>
                <p class="text-xs text-slate-500 font-medium">Status resmi kelulusan tahap seleksi anggota OSIS SMK Hijau Muda</p>
            </div>
        </div>

        <div class="p-5 rounded-2xl border text-center font-bold text-sm md:text-base transition-all
            @if($user->status_lulus == 'lolos') bg-emerald-50/80 border-emerald-200 text-emerald-800 shadow-sm
            @elseif($user->status_lulus == 'tidak_lolos') bg-red-50/80 border-red-200 text-red-800 shadow-sm
            @else bg-amber-50/80 border-amber-200 text-amber-800 shadow-sm @endif">
            @if($user->status_lulus == 'lolos')
                🎉 Selamat! Anda DINYATAKAN LOLOS seleksi Calon Anggota OSIS SMK Hijau Muda.
            @elseif($user->status_lulus == 'tidak_lolos')
                ❌ Mohon maaf, Anda belum berhasil lolos dalam seleksi kali ini. Tetap semangat dan jangan putus asa!
            @else
                ⏳ Status kelulusan Anda sedang dalam tahap peninjauan oleh Panitia. Silakan cek secara berkala.
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl mb-6 font-semibold text-sm flex items-center space-x-3 shadow-xs">
            <svg class="w-5 h-5 shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-2xl mb-6 font-semibold text-sm flex items-center space-x-3 shadow-xs">
            <svg class="w-5 h-5 shrink-0 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Informasi & Timeline Seleksi -->
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <h3 class="font-extrabold text-lg text-slate-900 mb-6 flex items-center space-x-2">
            <span>Timeline & Tahapan Seleksi Calon OSIS</span>
        </h3>
        
        <div class="space-y-4">
            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50/70 border border-slate-200/70 transition hover:bg-slate-50">
                <div class="bg-emerald-600 text-white font-extrabold h-10 w-10 rounded-2xl flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20 text-sm">1</div>
                <div>
                    <h4 class="font-bold text-slate-900 text-base">Pendaftaran & Pembuatan Akun</h4>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 leading-relaxed">Siswa terdaftar dan mendapatkan kredensial akun resmi dari panitia untuk masuk ke portal seleksi berbasis online.</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50/70 border border-slate-200/70 transition hover:bg-slate-50">
                <div class="bg-emerald-600 text-white font-extrabold h-10 w-10 rounded-2xl flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20 text-sm">2</div>
                <div>
                    <h4 class="font-bold text-slate-900 text-base">Seleksi Akademik (CAT)</h4>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 leading-relaxed">Mengerjakan ujian pilihan ganda secara online melalui menu <strong>Ujian Seleksi (CAT)</strong> di panel navigasi sesuai dengan jadwal sesi yang telah ditentukan.</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-5 rounded-2xl bg-slate-50/70 border border-slate-200/70 transition hover:bg-slate-50">
                <div class="bg-emerald-600 text-white font-extrabold h-10 w-10 rounded-2xl flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20 text-sm">3</div>
                <div>
                    <h4 class="font-bold text-slate-900 text-base">Pengumuman Kelulusan Akhir</h4>
                    <p class="text-xs md:text-sm text-slate-500 mt-1 leading-relaxed">Memantau status akhir kelulusan secara berkala melalui banner pengumuman interaktif yang tersedia di halaman dashboard ini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.student')

@section('title', 'Dashboard Siswa - Seleksi OSIS')

@section('content')
    <!-- Banner Pengumuman Kelulusan -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 mb-8">
        <h3 class="font-bold text-lg text-slate-800 mb-2">Pengumuman Hasil Seleksi Calon OSIS</h3>
        <div class="p-4 rounded-xl border text-center font-bold text-base
            @if($user->status_lulus == 'lolos') bg-emerald-50 border-emerald-200 text-emerald-700 
            @elseif($user->status_lulus == 'tidak_lolos') bg-red-50 border-red-200 text-red-700 
            @else bg-amber-50 border-amber-200 text-amber-700 @endif">
            @if($user->status_lulus == 'lolos')
                🎉 Selamat! Anda DINYATAKAN LOLOS seleksi Calon Anggota OSIS.
            @elseif($user->status_lulus == 'tidak_lolos')
                ❌ Mohon maaf, Anda belum berhasil lolos dalam seleksi kali ini. Tetap semangat!
            @else
                ⏳ Status kelulusan Anda sedang dalam tahap peninjauan oleh Panitia. Mohon menunggu.
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 font-medium text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl mb-6 font-medium text-sm">{{ session('error') }}</div>
    @endif

    <!-- Informasi & Timeline Seleksi -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="font-bold text-lg text-slate-800 mb-4">Timeline & Tahapan Seleksi Calon OSIS</h3>
        <div class="space-y-4">
            <div class="flex items-start space-x-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="bg-blue-600 text-white font-bold h-8 w-8 rounded-xl flex items-center justify-center shrink-0">1</div>
                <div>
                    <h4 class="font-bold text-slate-800">Pendaftaran & Pembuatan Akun</h4>
                    <p class="text-sm text-slate-500 mt-0.5">Siswa terdaftar dan mendapatkan akun dari panitia untuk masuk ke portal seleksi.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="bg-blue-600 text-white font-bold h-8 w-8 rounded-xl flex items-center justify-center shrink-0">2</div>
                <div>
                    <h4 class="font-bold text-slate-800">Seleksi Akademik (CAT)</h4>
                    <p class="text-sm text-slate-500 mt-0.5">Mengerjakan ujian pilihan ganda secara online melalui menu <strong>Ujian Seleksi</strong> di bagian atas sesuai jadwal yang ditentukan.</p>
                </div>
            </div>
            <div class="flex items-start space-x-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div class="bg-blue-600 text-white font-bold h-8 w-8 rounded-xl flex items-center justify-center shrink-0">3</div>
                <div>
                    <h4 class="font-bold text-slate-800">Pengumuman Kelulusan Akhir</h4>
                    <p class="text-sm text-slate-500 mt-0.5">Memantau status kelulusan secara berkala melalui banner pengumuman di halaman dashboard ini.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.student')

@section('title', 'Ujian Seleksi - Seleksi OSIS')
@section('header-title', 'Ujian Seleksi (CAT)')

@section('content')
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

    <!-- Daftar Jadwal Ujian CAT -->
    <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xs border border-slate-200/80">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100">
            <div>
                <h3 class="font-extrabold text-lg text-slate-900">Daftar Ujian Akademik CAT</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Pilih dan ikuti jadwal ujian seleksi calon anggota OSIS yang aktif</p>
            </div>
            <div class="h-10 w-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            </div>
        </div>

        <div class="space-y-4">
            @forelse($exams as $exam)
            @php
                $statusExam = $studentExams[$exam->id]->status ?? 'belum_mulai';
            @endphp
            <div class="p-5 md:p-6 border border-slate-200/80 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-slate-50/70 hover:bg-slate-50 transition">
                <div class="space-y-1.5 flex-1">
                    <div class="flex items-center space-x-2">
                        <span class="bg-emerald-100 text-emerald-800 font-extrabold px-2.5 py-0.5 rounded-lg text-[10px] uppercase tracking-wider">Ujian Aktif</span>
                    </div>
                    <h4 class="font-extrabold text-slate-900 text-base md:text-lg">{{ $exam->title }}</h4>
                    <p class="text-xs md:text-sm text-slate-500 leading-relaxed">{{ $exam->description ?? 'Tidak ada deskripsi ujian.' }}</p>
                    
                    <div class="flex items-center space-x-4 pt-1 text-xs font-semibold text-slate-400">
                        <div class="flex items-center space-x-1.5">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Durasi: <strong class="text-slate-700">{{ $exam->duration_minutes }} Menit</strong></span>
                        </div>
                    </div>
                </div>

                <div class="w-full sm:w-auto shrink-0 pt-2 sm:pt-0">
                    @if($statusExam == 'selesai')
                        <div class="w-full sm:w-auto text-center bg-emerald-50 border border-emerald-200 text-emerald-700 font-extrabold px-5 py-3 rounded-2xl text-xs flex items-center justify-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Ujian Selesai</span>
                        </div>
                    @else
                        <a href="{{ route('student.exam.room', $exam->id) }}" class="w-full sm:w-auto text-center bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20 inline-flex items-center justify-center space-x-2">
                            <span>Mulai Ujian</span>
                            <span>→</span>
                        </a>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-12 px-4 rounded-2xl border border-dashed border-slate-200 bg-slate-50/50">
                <div class="h-12 w-12 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <p class="font-bold text-slate-700 text-sm">Belum ada jadwal ujian tersedia</p>
                <p class="text-xs text-slate-400 mt-1">Panitia belum membuka sesi ujian CAT baru untuk saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
@endsection
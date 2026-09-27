@extends('layouts.student')

@section('title', 'Ujian Seleksi - Seleksi OSIS')

@section('content')
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-xl mb-6 font-medium text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-xl mb-6 font-medium text-sm">{{ session('error') }}</div>
    @endif

    <!-- Daftar Jadwal Ujian CAT -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
        <h3 class="font-bold text-lg text-slate-800 mb-4">Daftar Ujian Akademik CAT</h3>
        <div class="space-y-4">
            @forelse($exams as $exam)
            @php
                $statusExam = $studentExams[$exam->id]->status ?? 'belum_mulai';
            @endphp
            <div class="p-5 border border-slate-200 rounded-xl flex justify-between items-center bg-slate-50">
                <div>
                    <h4 class="font-bold text-slate-800 text-lg">{{ $exam->title }}</h4>
                    <p class="text-sm text-slate-500 mt-0.5">{{ $exam->description ?? 'Tidak ada deskripsi ujian.' }}</p>
                    <p class="text-xs text-slate-400 mt-2">Durasi Pengerjaan: {{ $exam->duration_minutes }} Menit</p>
                </div>
                <div>
                    @if($statusExam == 'selesai')
                        <span class="bg-emerald-100 text-emerald-700 font-bold px-4 py-2 rounded-xl text-xs">Ujian Selesai</span>
                    @else
                        <a href="{{ route('student.exam.room', $exam->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs transition shadow-sm inline-block">Mulai Ujian</a>
                    @endif
                </div>
            </div>
            @empty
            <p class="text-center text-slate-400 py-4">Belum ada jadwal ujian yang tersedia saat ini.</p>
            @endforelse
        </div>
    </div>
@endsection
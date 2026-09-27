@extends('layouts.admin')

@section('title', 'Builder Soal - ' . $exam->title)
@section('header-title', 'Kelola Soal: ' . $exam->title)

@section('content')
    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-4 rounded-2xl font-semibold text-sm flex items-center space-x-3 shadow-xs">
                <span>✅</span>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-2xl font-semibold text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 1. Form Upload Soal via Excel & Tombol Download Template -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 pb-6 border-b border-slate-100">
                <div class="space-y-1">
                    <h3 class="font-extrabold text-slate-900 text-base">Import Soal via Excel</h3>
                    <p class="text-xs text-slate-500 font-medium">Upload file Excel (<code class="bg-slate-100 px-1.5 py-0.5 rounded text-emerald-600 font-mono">.xlsx</code>) berisi daftar soal dan bobot poin.</p>
                </div>
                <a href="{{ route('admin.builder.template') }}" class="inline-flex items-center space-x-2 bg-slate-100 hover:bg-slate-200 text-slate-700 px-5 py-3 rounded-2xl font-extrabold text-xs transition">
                    <span>📥</span>
                    <span>Download Template Excel</span>
                </a>
            </div>
            
            <form action="{{ route('admin.builder.import', $exam->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-4 items-center">
                @csrf
                <input type="file" name="file" accept=".xlsx, .xls" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-5 file:rounded-2xl file:border-0 file:text-xs file:font-extrabold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 border border-slate-300 rounded-2xl p-2 bg-slate-50/50 cursor-pointer" required>
                <button type="submit" class="w-full md:w-auto bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 px-6 rounded-2xl transition text-xs shadow-md shadow-emerald-600/20 shrink-0">Upload & Import 🚀</button>
            </form>
        </div>

        <!-- 2. Form Tambah Soal Manual -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
            <div class="flex items-center space-x-3">
                <div class="h-10 w-10 bg-emerald-50 text-emerald-600 font-bold rounded-2xl flex items-center justify-center text-lg shadow-inner">✍️</div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Soal Manual</h3>
                    <p class="text-xs text-slate-500 font-medium">Buat butir pertanyaan pilihan ganda secara langsung.</p>
                </div>
            </div>

            <form action="{{ route('admin.builder.store', $exam->id) }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pertanyaan / Soal</label>
                    <textarea name="question_text" rows="3" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" placeholder="Tuliskan pertanyaan di sini..." required></textarea>
                </div>

                <div class="space-y-3 pt-2">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Opsi Jawaban & Bobot Poin</label>
                    @for($i = 0; $i < 4; $i++)
                    <div class="flex gap-3 items-center">
                        <div class="bg-slate-100 text-slate-700 font-black text-xs w-11 h-11 rounded-2xl flex items-center justify-center shrink-0 border border-slate-200">
                            {{ chr(65 + $i) }}
                        </div>
                        <input type="text" name="options[]" placeholder="Teks Opsi Jawaban {{ chr(65 + $i) }}" class="flex-1 px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                        <input type="number" name="points[]" placeholder="Poin" class="w-28 px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" value="0" required>
                    </div>
                    @endfor
                </div>

                <div class="pt-2 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 px-8 rounded-2xl transition text-xs shadow-md shadow-emerald-600/20">Simpan Soal Manual ✨</button>
                </div>
            </form>
        </div>

        <!-- 3. Daftar Soal Terdaftar -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Soal Tersimpan</h3>
                <span class="bg-emerald-50 text-emerald-700 text-xs font-extrabold px-3.5 py-1.5 rounded-xl border border-emerald-200">Total: {{ $exam->questions->count() }} Soal</span>
            </div>

            <div class="space-y-4">
                @forelse($exam->questions as $index => $q)
                <div class="p-6 border border-slate-200/80 rounded-2xl bg-slate-50/50 space-y-4">
                    <div class="flex items-start space-x-3.5">
                        <div class="bg-slate-900 text-white font-black text-xs w-8 h-8 rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                            {{ $index + 1 }}
                        </div>
                        <p class="font-extrabold text-slate-900 text-sm md:text-base leading-relaxed pt-1">
                            {{ $q->question_text }}
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2.5 text-xs pl-0 md:pl-11">
                        @foreach($q->options as $optIndex => $opt)
                        <div class="bg-white p-3.5 border border-slate-200/80 rounded-xl flex justify-between items-center shadow-xs">
                            <div class="flex items-center space-x-2.5">
                                <span class="bg-slate-100 text-slate-600 font-bold px-2 py-1 rounded-lg text-[11px]">{{ chr(65 + $optIndex) }}</span>
                                <span class="text-slate-700 font-medium">{{ $opt->option_text }}</span>
                            </div>
                            <span class="bg-emerald-50 text-emerald-700 font-extrabold px-2.5 py-1 rounded-lg text-xs border border-emerald-200">+{{ $opt->points }} Poin</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="text-center py-12 space-y-2">
                    <p class="text-slate-400 text-sm font-medium">Belum ada soal untuk ujian ini.</p>
                    <p class="text-slate-400 text-xs">Silakan tambahkan secara manual atau upload file Excel melalui opsi di atas.</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
@endsection
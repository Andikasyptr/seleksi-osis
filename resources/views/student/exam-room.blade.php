@extends('layouts.student')

@section('title', 'Ruang Ujian - ' . $exam->title)

@section('content')
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        
        <!-- Header Info Ujian -->
        <div class="bg-white p-5 md:p-6 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <span class="bg-blue-50 text-blue-700 font-bold px-3 py-1 rounded-xl text-xs">Ujian CAT OSIS</span>
                <h2 class="text-base md:text-lg font-extrabold text-slate-900 mt-1">{{ $exam->title }}</h2>
            </div>
            <div class="flex items-center space-x-2 w-full sm:w-auto justify-between sm:justify-end">
                <div class="bg-slate-900 text-white px-4 py-2 rounded-2xl text-xs font-bold">
                    Waktu: <span class="text-blue-400">{{ $exam->duration_minutes }} Menit</span>
                </div>
                <!-- Tombol Trigger Navigasi Khusus Mobile -->
                <button type="button" onclick="toggleMobileNav(true)" class="lg:hidden bg-blue-600 text-white px-4 py-2 rounded-2xl text-xs font-bold flex items-center space-x-1.5 shadow-sm">
                    <span>📋 Daftar Soal</span>
                </button>
            </div>
        </div>

        <form action="{{ route('student.exam.submit', $exam->id) }}" method="POST" id="exam-form">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
                
                <!-- Area Soal (Kiri - Lebar 3 Kolom) -->
                <div class="lg:col-span-3 space-y-6">
                    @foreach($exam->questions as $index =>$q)
                    <div class="question-card bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 space-y-6 {{ $index > 0 ? 'hidden' : '' }}" data-index="{{ $index }}">
                        
                        <!-- Nomor & Pertanyaan -->
                        <div class="flex items-start space-x-3.5">
                            <div class="bg-blue-600 text-white font-black text-sm w-9 h-9 rounded-2xl flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
                                {{ $index + 1 }}
                            </div>
                            <div class="pt-1.5 flex-1">
                                <p class="font-bold text-slate-900 text-sm md:text-base leading-relaxed">
                                    {{ $q->question_text }}
                                </p>
                            </div>
                        </div>

                        <!-- Opsi Jawaban -->
                        <div class="space-y-3 pt-2">
                            @foreach($q->options as $optIndex =>$opt)
                            <label class="flex items-center space-x-3.5 p-4 rounded-2xl border border-slate-200 hover:bg-blue-50/40 hover:border-blue-300 cursor-pointer transition group">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}" data-question="{{ $index }}" onchange="markAnswered({{ $index }})" class="question-radio text-blue-600 focus:ring-blue-500 w-4 h-4 cursor-pointer">
                                <span class="text-xs font-black text-slate-400 bg-slate-100 w-6 h-6 rounded-lg flex items-center justify-center shrink-0 group-hover:bg-blue-100 group-hover:text-blue-600 transition">
                                    {{ chr(65 + $optIndex) }}
                                </span>
                                <span class="text-sm font-medium text-slate-700 group-hover:text-slate-900">{{ $opt->option_text }}</span>
                            </label>
                            @endforeach
                        </div>

                        <!-- Navigasi Tombol Sebelumnya / Selanjutnya -->
                        <div class="flex justify-between items-center pt-6 border-t border-slate-100">
                            <button type="button" onclick="changeQuestion({{ $index - 1 }})" class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition {{ $index == 0 ? 'invisible' : '' }}">
                                ← Sebelumnya
                            </button>

                            @if($index < count($exam->questions) - 1)
                                <button type="button" onclick="changeQuestion({{ $index + 1 }})" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-blue-600/20">
                                    Selanjutnya →
                                </button>
                            @else
                                <button type="button" onclick="confirmSubmit()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20">
                                    Selesai & Kumpulkan 🚀
                                </button>
                            @endif
                        </div>

                    </div>
                    @endforeach
                </div>

                <!-- Panel Navigasi Nomor Soal & Tombol Kumpul Cepat -->
                <div id="nav-panel" class="hidden lg:block lg:col-span-1 bg-white p-6 rounded-3xl shadow-sm border border-slate-200/80 space-y-4 sticky top-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm">Navigasi Soal</h3>
                            <p class="text-[11px] text-slate-400">Klik nomor untuk pindah.</p>
                        </div>
                        <button type="button" onclick="toggleMobileNav(false)" class="lg:hidden text-slate-400 hover:text-slate-700 p-1">
                            ✕
                        </button>
                    </div>

                    <!-- Grid Tombol Nomor -->
                    <div class="grid grid-cols-5 lg:grid-cols-4 gap-2 max-h-56 lg:max-h-72 overflow-y-auto p-1">
                        @foreach($exam->questions as $index =>$q)
                        <button type="button" id="nav-btn-{{ $index }}" onclick="changeQuestion({{ $index }}); toggleMobileNav(false);" class="nav-btn h-11 rounded-2xl font-bold text-xs border border-slate-200 bg-slate-100 text-slate-600 hover:border-blue-400 transition flex items-center justify-center">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-[11px] font-medium text-slate-500">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-lg bg-blue-600 inline-block"></span>
                            <span>Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-lg bg-slate-100 border border-slate-300 inline-block"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>

                    <!-- Tombol Kumpul Cepat di Panel Samping (Desktop & Mobile Drawer) -->
                    <div class="pt-2">
                        <button type="button" onclick="confirmSubmit()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3 px-4 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20 flex items-center justify-center space-x-1.5">
                            <span>Selesai & Kumpulkan</span>
                            <span>🚀</span>
                        </button>
                    </div>
                </div>

            </div>
        </form>

    </div>

    <!-- Backdrop untuk Mobile Drawer -->
    <div id="nav-backdrop" onclick="toggleMobileNav(false)" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

    <!-- Script Navigasi CAT & SweetAlert2 -->
    <script>
        let currentIndex = 0;
        const totalQuestions = {{ count($exam->questions) }};

        function changeQuestion(index) {
            if (index < 0 || index >= totalQuestions) return;

            document.querySelectorAll('.question-card').forEach(card => {
                card.classList.add('hidden');
            });

            document.querySelector(`.question-card[data-index="${index}"]`).classList.remove('hidden');
            currentIndex = index;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function markAnswered(index) {
            const navBtn = document.getElementById(`nav-btn-${index}`);
            if (navBtn) {
                navBtn.classList.remove('bg-slate-100', 'text-slate-600', 'border-slate-200');
                navBtn.classList.add('bg-blue-600', 'text-white', 'border-blue-600', 'shadow-md', 'shadow-blue-600/20');
            }
        }

        function toggleMobileNav(show) {
            const panel = document.getElementById('nav-panel');
            const backdrop = document.getElementById('nav-backdrop');
            
            if (show) {
                panel.classList.remove('hidden');
                panel.classList.add('fixed', 'inset-x-4', 'bottom-4', 'top-auto', 'z-50', 'max-h-[85vh]', 'overflow-y-auto');
                backdrop.classList.remove('hidden');
            } else {
                panel.classList.remove('fixed', 'inset-x-4', 'bottom-4', 'top-auto', 'z-50', 'max-h-[85vh]', 'overflow-y-auto');
                if (window.innerWidth < 1024) {
                    panel.classList.add('hidden');
                }
                backdrop.classList.add('hidden');
            }
        }

        function confirmSubmit() {
            Swal.fire({
                title: 'Kumpulkan Jawaban?',
                text: "Pastikan semua soal telah dikerjakan dengan teliti sebelum dikumpulkan.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#059669',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Kumpulkan!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-2xl px-6 py-3 font-bold text-sm',
                    cancelButton: 'rounded-2xl px-6 py-3 font-bold text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('exam-form').submit();
                }
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('.question-radio').forEach(radio => {
                if (radio.checked) {
                    markAnswered(radio.getAttribute('data-question'));
                }
            });
        });
    </script>
@endsection
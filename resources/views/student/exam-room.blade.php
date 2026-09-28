@extends('layouts.student')

@section('title', 'Ruang Ujian - ' . $exam->title)
@section('header-title', 'Ujian CAT: ' . $exam->title)

@section('content')
    <!-- CDN SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        
        <!-- Header Info Ujian & Timer -->
        <div class="bg-white p-5 md:p-6 rounded-3xl shadow-xs border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <span class="bg-emerald-50 text-emerald-700 font-extrabold px-3 py-1.5 rounded-xl text-xs uppercase tracking-wide">Ujian CAT OSIS</span>
                <h2 class="text-base md:text-lg font-extrabold text-slate-900 mt-1.5">{{ $exam->title }}</h2>
            </div>
            
            <div class="flex items-center space-x-3 w-full sm:w-auto justify-between sm:justify-end">
                <!-- Countdown Timer Badge -->
                <div class="bg-slate-900 text-white px-4 py-2.5 rounded-2xl text-xs font-bold flex items-center space-x-2 shadow-sm">
                    <svg class="w-4 h-4 text-emerald-400 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>Sisa Waktu: <strong id="timer-display" class="text-emerald-400 tracking-wider">--:--</strong></span>
                </div>

                <!-- Tombol Trigger Navigasi Khusus Mobile -->
                <button type="button" onclick="toggleMobileNav(true)" class="lg:hidden bg-emerald-600 text-white px-4 py-2.5 rounded-2xl text-xs font-bold flex items-center space-x-1.5 shadow-sm">
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
                    <div class="question-card bg-white p-6 md:p-8 rounded-3xl shadow-xs border border-slate-200/80 space-y-6 {{ $index > 0 ? 'hidden' : '' }}" data-index="{{ $index }}">
                        
                        <!-- Nomor & Pertanyaan -->
                        <div class="flex items-start space-x-4">
                            <div class="bg-emerald-600 text-white font-black text-sm w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 shadow-md shadow-emerald-600/20">
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
                            <label class="flex items-center space-x-3.5 p-4 rounded-2xl border border-slate-200/80 hover:bg-emerald-50/40 hover:border-emerald-300 cursor-pointer transition group">
                                <input type="radio" name="answers[{{ $q->id }}]" value="{{ $opt->id }}" data-question="{{ $index }}" onchange="markAnswered({{ $index }})" class="question-radio text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                                <span class="text-xs font-black text-slate-400 bg-slate-100 w-7 h-7 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition">
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
                                <button type="button" onclick="changeQuestion({{ $index + 1 }})" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20">
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
                <div id="nav-panel" class="hidden lg:block lg:col-span-1 bg-white p-6 rounded-3xl shadow-xs border border-slate-200/80 space-y-4 sticky top-28">
                    <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                        <div>
                            <h3 class="font-extrabold text-slate-900 text-sm">Navigasi Soal</h3>
                            <p class="text-[11px] text-slate-400 font-medium">Klik nomor untuk pindah</p>
                        </div>
                        <button type="button" onclick="toggleMobileNav(false)" class="lg:hidden text-slate-400 hover:text-slate-700 p-1 font-bold text-sm">
                            ✕
                        </button>
                    </div>

                    <!-- Grid Tombol Nomor -->
                    <div class="grid grid-cols-5 lg:grid-cols-4 gap-2 max-h-56 lg:max-h-72 overflow-y-auto p-1">
                        @foreach($exam->questions as $index =>$q)
                        <button type="button" id="nav-btn-{{ $index }}" onclick="changeQuestion({{ $index }}); toggleMobileNav(false);" class="nav-btn h-11 rounded-2xl font-bold text-xs border border-slate-200 bg-slate-100 text-slate-600 hover:border-emerald-400 transition flex items-center justify-center">
                            {{ $index + 1 }}
                        </button>
                        @endforeach
                    </div>

                    <div class="pt-3 border-t border-slate-100 space-y-2 text-[11px] font-medium text-slate-500">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-lg bg-emerald-600 inline-block shadow-xs"></span>
                            <span>Sudah Dijawab</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-lg bg-slate-100 border border-slate-300 inline-block"></span>
                            <span>Belum Dijawab</span>
                        </div>
                    </div>

                    <!-- Tombol Kumpul Cepat di Panel Samping -->
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
    <div id="nav-backdrop" onclick="toggleMobileNav(false)" class="fixed inset-0 bg-slate-900/50 backdrop-blur-xs z-40 hidden lg:hidden"></div>

    <!-- Script Navigasi CAT, Timer, & SweetAlert2 -->
    <script>
        let currentIndex = 0;
        const totalQuestions = {{ count($exam->questions) }};

        // Konfigurasi Timer Ujian (Durasi dalam Menit)
        let totalSeconds = {{ $exam->duration_minutes }} * 60;

        function startTimer() {
            const timerDisplay = document.getElementById('timer-display');
            
            const timerInterval = setInterval(() => {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    Swal.fire({
                        title: 'Waktu Ujian Habis!',
                        text: 'Ujian akan dikumpulkan secara otomatis oleh sistem.',
                        icon: 'info',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#059669',
                        allowOutsideClick: false,
                        customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-2xl px-6 py-3 font-bold' }
                    }).then(() => {
                        document.getElementById('exam-form').submit();
                    });
                    return;
                }

                totalSeconds--;
                let hours = Math.floor(totalSeconds / 3600);
                let minutes = Math.floor((totalSeconds % 3600) / 60);
                let seconds = totalSeconds % 60;

                let formattedTime = '';
                if (hours > 0) {
                    formattedTime += `${hours.toString().padStart(2, '0')}:`;
                }
                formattedTime += `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                
                timerDisplay.innerText = formattedTime;
            }, 1000);
        }

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
                navBtn.classList.add('bg-emerald-600', 'text-white', 'border-emerald-600', 'shadow-md', 'shadow-emerald-600/20');
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
            // Jalankan Timer
            startTimer();

            // Tandai tombol soal yang sudah terisi saat halaman dimuat
            document.querySelectorAll('.question-radio').forEach(radio => {
                if (radio.checked) {
                    markAnswered(radio.getAttribute('data-question'));
                }
            });
        });
    </script>
@endsection
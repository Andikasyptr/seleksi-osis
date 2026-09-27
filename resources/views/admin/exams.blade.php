@extends('layouts.admin')

@section('title', 'Jadwal Ujian - Admin Panel')
@section('header-title', 'Kelola Jadwal Ujian CAT')

@section('content')
    <!-- CDN SweetAlert2 untuk Konfirmasi Hapus -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="space-y-8">
        
        <!-- Notifikasi Sukses -->
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

        <!-- Action Bar: Tombol Buka Modal Buat Ujian -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 gap-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900">Daftar Jadwal Ujian Seleksi</h3>
                <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola sesi ujian akademik dan penilaian calon anggota OSIS.</p>
            </div>
            <button onclick="toggleModal('create-modal', true)" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3.5 rounded-2xl transition shadow-md shadow-emerald-600/20 text-xs flex items-center space-x-2">
                <span>➕</span>
                <span>Buat Ujian Baru</span>
            </button>
        </div>

        <!-- Daftar Ujian (Tabel) -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-500 border-b border-slate-200 text-xs uppercase tracking-wider">
                            <th class="p-5 font-bold">Judul & Deskripsi Ujian</th>
                            <th class="p-5 font-bold">Waktu Mulai</th>
                            <th class="p-5 font-bold">Waktu Selesai</th>
                            <th class="p-5 font-bold">Durasi</th>
                            <th class="p-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium">
                        @forelse($exams as $exam)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-5">
                                <p class="font-extrabold text-slate-900">{{ $exam->title }}</p>
                                <p class="text-xs text-slate-500 font-normal mt-0.5 line-clamp-1">{{ $exam->description ?? 'Tidak ada deskripsi.' }}</p>
                            </td>
                            <td class="p-5 text-slate-600 text-xs font-mono">{{ $exam->start_time }}</td>
                            <td class="p-5 text-slate-600 text-xs font-mono">{{ $exam->end_time }}</td>
                            <td class="p-5">
                                <span class="bg-emerald-50 text-emerald-700 font-extrabold px-3.5 py-1.5 rounded-xl text-xs border border-emerald-200">
                                    {{ $exam->duration_minutes }} Menit
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Tombol Soal -->
                                    <a href="{{ route('admin.builder', $exam->id) }}" class="bg-slate-900 hover:bg-slate-800 text-white px-3.5 py-2 rounded-xl font-bold text-xs transition shadow-xs flex items-center space-x-1" title="Kelola Soal">
                                        <span>📝</span>
                                        <!-- <span>Soal</span> -->
                                    </a>
                                    <!-- Tombol Edit -->
                                    <button onclick="openEditModal({{ json_encode($exam) }})" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3.5 py-2 rounded-xl font-bold text-xs transition border border-amber-200 flex items-center space-x-1" title="Edit Ujian">
                                        <span>✏️</span>
                                        <!-- <span>Edit</span> -->
                                    </button>
                                    <!-- Form Hapus -->
                                    <form action="{{ route('admin.exams.destroy', $exam->id) }}" method="POST" id="delete-exam-form-{{ $exam->id }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteExam('{{ $exam->id }}', '{{$exam->title }}')" class="bg-red-50 hover:bg-red-100 text-red-600 px-3.5 py-2 rounded-xl font-bold text-xs transition border border-red-200 flex items-center space-x-1" title="Hapus Ujian">
                                            <span>🗑️</span>
                                            <!-- <span>Hapus</span> -->
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 text-sm font-medium">
                                Belum ada jadwal ujian yang dibuat. Klik tombol <strong>"Buat Ujian Baru"</strong> di atas untuk memulai.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Form Buat Ujian Baru (Popup) -->
    <div id="create-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-xl w-full p-6 md:p-8 transform transition-all space-y-6">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Buat Jadwal Ujian Baru</h3>
                    <p class="text-xs text-slate-500 font-medium">Tentukan durasi dan waktu pelaksanaan ujian CAT.</p>
                </div>
                <button onclick="toggleModal('create-modal', false)" class="text-slate-400 hover:text-slate-700 bg-slate-100 p-2 rounded-xl font-bold">✕</button>
            </div>

            <form action="{{ route('admin.exams.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Judul Ujian</label>
                    <input type="text" name="title" placeholder="Contoh: Seleksi Akademik Calon OSIS" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Deskripsi / Instruksi</label>
                    <textarea name="description" rows="2" placeholder="Instruksi singkat pengerjaan ujian..." class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Waktu Mulai</label>
                        <input type="datetime-local" name="start_time" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Waktu Selesai</label>
                        <input type="datetime-local" name="end_time" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Durasi Ujian (Menit)</label>
                    <input type="number" name="duration_minutes" placeholder="Contoh: 90" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('create-modal', false)" class="px-5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 font-bold text-xs transition">Batal</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3 rounded-2xl transition text-xs shadow-md shadow-emerald-600/20">Simpan Jadwal Ujian</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Edit Ujian (Popup) -->
    <div id="edit-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 max-w-xl w-full p-6 md:p-8 transform transition-all space-y-6">
            <div class="flex justify-between items-center pb-4 border-b border-slate-100">
                <div>
                    <h3 class="text-lg font-black text-slate-900">Edit Jadwal Ujian</h3>
                    <p class="text-xs text-slate-500 font-medium">Perbarui informasi dan waktu pelaksanaan ujian.</p>
                </div>
                <button onclick="toggleModal('edit-modal', false)" class="text-slate-400 hover:text-slate-700 bg-slate-100 p-2 rounded-xl font-bold">✕</button>
            </div>

            <form id="edit-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Judul Ujian</label>
                    <input type="text" id="edit-title" name="title" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Deskripsi / Instruksi</label>
                    <textarea id="edit-description" name="description" rows="2" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50"></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Waktu Mulai</label>
                        <input type="datetime-local" id="edit-start-time" name="start_time" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Waktu Selesai</label>
                        <input type="datetime-local" id="edit-end-time" name="end_time" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5 uppercase tracking-wider">Durasi Ujian (Menit)</label>
                    <input type="number" id="edit-duration" name="duration_minutes" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50" required>
                </div>

                <div class="flex justify-end space-x-3 pt-4 border-t border-slate-100">
                    <button type="button" onclick="toggleModal('edit-modal', false)" class="px-5 py-3 rounded-2xl text-slate-600 hover:bg-slate-100 font-bold text-xs transition">Batal</button>
                    <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white font-extrabold px-6 py-3 rounded-2xl transition text-xs shadow-md shadow-amber-600/20">Perbarui Jadwal Ujian</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal Toggle & SweetAlert Hapus -->
    <script>
        function toggleModal(modalId, show) {
            const modal = document.getElementById(modalId);
            if (show) {
                modal.classList.remove('hidden');
            } else {
                modal.classList.add('hidden');
            }
        }

        function openEditModal(exam) {
            const form = document.getElementById('edit-form');
            form.action = `/admin/exams/${exam.id}`;
            
            document.getElementById('edit-title').value = exam.title;
            document.getElementById('edit-description').value = exam.description || '';
            document.getElementById('edit-start-time').value = exam.start_time ? exam.start_time.replace(' ', 'T') : '';
            document.getElementById('edit-end-time').value = exam.end_time ? exam.end_time.replace(' ', 'T') : '';
            document.getElementById('edit-duration').value = exam.duration_minutes;

            toggleModal('edit-modal', true);
        }

        function confirmDeleteExam(id, title) {
            Swal.fire({
                title: 'Hapus Jadwal Ujian?',
                text: `Apakah Anda yakin ingin menghapus ujian "${title}"? Seluruh soal terkait juga akan terhapus.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-2xl px-6 py-3 font-bold text-sm',
                    cancelButton: 'rounded-2xl px-6 py-3 font-bold text-sm'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-exam-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
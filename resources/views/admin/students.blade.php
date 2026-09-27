@extends('layouts.admin')

@section('title', 'Kelola Siswa - Admin Panel')
@section('header-title', 'Kelola Akun Siswa')

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

        <!-- Form Tambah Siswa -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80">
            <div class="flex items-center space-x-3 mb-6">
                <div class="h-10 w-10 bg-emerald-50 text-emerald-600 font-bold rounded-2xl flex items-center justify-center text-lg shadow-inner">👤</div>
                <div>
                    <h3 class="font-extrabold text-slate-900 text-base">Tambah Akun Siswa Baru</h3>
                    <p class="text-xs text-slate-500 font-medium">Daftarkan kandidat peserta seleksi OSIS secara manual.</p>
                </div>
            </div>

            <form action="{{ route('admin.students.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @csrf
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" name="name" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50 transition" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Username / NIS</label>
                    <input type="text" name="username" placeholder="Contoh: 20261001" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50 transition" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full px-4 py-3 border border-slate-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 text-sm font-semibold bg-slate-50/50 transition" required>
                </div>
                <div class="md:col-span-3 pt-2 flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold py-3.5 px-8 rounded-2xl transition duration-200 shadow-md shadow-emerald-600/20 text-xs flex items-center space-x-2">
                        <span>Simpan Akun Siswa</span>
                        <span>✨</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tabel Siswa -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-extrabold text-slate-900 text-base">Daftar Seluruh Siswa</h3>
                <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-xl">Total: {{ count($students) }} Siswa</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 text-slate-500 border-b border-slate-200 text-xs uppercase tracking-wider">
                            <th class="p-5 font-bold">Nama Lengkap</th>
                            <th class="p-5 font-bold">Username / NIS</th>
                            <th class="p-5 font-bold">Status Kelulusan</th>
                            <th class="p-5 font-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm font-medium">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-5 font-bold text-slate-900">{{ $student->name }}</td>
                            <td class="p-5 text-slate-600 font-mono text-xs">{{ $student->username }}</td>
                            <td class="p-5">
                                @php
                                    $statusClass = [                                         'lolos' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',                                         'tidak_lolos' => 'bg-red-50 text-red-700 border border-red-200',                                         'pending' => 'bg-amber-50 text-amber-700 border border-amber-200'                                     ][$student->status_lulus] ?? 'bg-slate-100 text-slate-600';
                                @endphp
                                <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold uppercase tracking-wider {{ $statusClass }}">
                                    {{ str_replace('_', ' ', $student->status_lulus) }}
                                </span>
                            </td>
                            <td class="p-5 text-center">
                                <div class="inline-flex items-center space-x-2">
                                    <!-- Tombol Edit -->
                                    <button onclick="openEditModal('{{ $student->id }}', '{{ $student->name }}', '{{$student->username }}')" class="bg-amber-50 hover:bg-amber-100 text-amber-700 px-3 py-2 rounded-xl text-xs font-bold border border-amber-200 transition">
                                        ✏️ Edit
                                    </button>

                                    <!-- Form Hapus -->
                                    <form action="{{ route('admin.students.destroy', $student->id) }}" method="POST" id="delete-form-{{ $student->id }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('{{ $student->id }}', '{{$student->name }}')" class="bg-red-50 hover:bg-red-100 text-red-700 px-3 py-2 rounded-xl text-xs font-bold border border-red-200 transition">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-400 text-sm font-medium">
                                Belum ada data siswa terdaftar di dalam sistem.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Modal Edit Siswa -->
    <div id="edit-modal" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg p-8 rounded-3xl shadow-2xl border border-slate-200 space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-extrabold text-slate-900 text-lg">Edit Akun Siswa</h3>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-700 font-bold text-lg">✕</button>
            </div>

            <form id="edit-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Nama Lengkap</label>
                    <input type="text" id="edit-name" name="name" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm font-semibold bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Username / NIS</label>
                    <input type="text" id="edit-username" name="username" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm font-semibold bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-600" required>
                </div>
                <div>
                    <label class="block text-slate-700 text-xs font-bold uppercase tracking-wider mb-2">Password Baru <span class="text-slate-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <input type="password" name="password" placeholder="Minimal 6 karakter" class="w-full px-4 py-3 border border-slate-300 rounded-2xl text-sm font-semibold bg-slate-50 focus:outline-none focus:ring-2 focus:ring-emerald-600">
                </div>
                <div class="pt-4 flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-3 rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold text-xs transition">Batal</button>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Modal & SweetAlert Hapus -->
    <script>
        function openEditModal(id, name, username) {
            const modal = document.getElementById('edit-modal');
            const form = document.getElementById('edit-form');
            
            form.action = `/admin/students/${id}`;
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-username').value = username;

            modal.classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('edit-modal').classList.add('hidden');
        }

        function confirmDelete(id, name) {
            Swal.fire({
                title: 'Hapus Akun Siswa?',
                text: `Apakah Anda yakin ingin menghapus akun "${name}"? Tindakan ini tidak dapat dibatalkan.`,
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
                    document.getElementById(`delete-form-${id}`).submit();
                }
            });
        }
    </script>
@endsection
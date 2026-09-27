@extends('layouts.admin')

@section('title', 'Rekap Nilai - Admin Panel')
@section('header-title', 'Rekap Nilai & Kelulusan Siswa')

@section('content')
    <div class="space-y-8">
        
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

        <!-- Form & Tabel Rekap -->
        <form action="{{ route('admin.students.bulk-status') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Aksi Massal (Bulk Action Bar) -->
            <div class="bg-white p-6 md:p-8 rounded-3xl shadow-sm border border-slate-200/80 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="space-y-1">
                    <h3 class="text-base font-extrabold text-slate-900">Manajemen Status Kelulusan</h3>
                    <p class="text-xs text-slate-500 font-medium">Ubah status kelulusan kandidat secara massal atau satuan.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    <select name="status_lulus" class="px-4 py-3 border border-slate-300 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-slate-50/50">
                        <option value="lolos">🟢 Luluskan Siswa Terpilih</option>
                        <option value="tidak_lolos">🔴 Tandai Tidak Lolos</option>
                        <option value="pending">🟡 Kembalikan ke Pending</option>
                    </select>
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold px-6 py-3 rounded-2xl text-xs transition shadow-md shadow-emerald-600/20 shrink-0">
                        Terapkan 🚀
                    </button>
                </div>
            </div>

            <!-- Tabel Data -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200/80 overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-extrabold text-slate-900 text-base">Rekapitulasi Hasil Ujian Kandidat</h3>
                    <span class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-1.5 rounded-xl">Total Data: {{ count($results) }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50/70 text-slate-500 border-b border-slate-200 text-xs uppercase tracking-wider">
                                <th class="p-5 font-bold w-12 text-center">
                                    <input type="checkbox" id="select-all" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                                </th>
                                <th class="p-5 font-bold">Nama Siswa</th>
                                <th class="p-5 font-bold">Ujian Terakhir</th>
                                <th class="p-5 font-bold">Total Skor</th>
                                <th class="p-5 font-bold">Status Kelulusan Saat Ini</th>
                                <th class="p-5 font-bold text-center">Aksi Satuan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm font-medium">
                            @forelse($results as $res)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-5 text-center">
                                    <input type="checkbox" name="student_ids[]" value="{{ $res->user->id }}" class="student-checkbox rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                                </td>
                                <td class="p-5 font-bold text-slate-900">{{ $res->user->name }}</td>
                                <td class="p-5 text-slate-600 text-xs font-semibold">{{ $res->exam->title }}</td>
                                <td class="p-5 font-black text-emerald-600 text-base">{{ $res->total_score }}</td>
                                <td class="p-5">
                                    @php
                                        $statusClass = [                                             'lolos' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',                                             'tidak_lolos' => 'bg-red-50 text-red-700 border border-red-200',                                             'pending' => 'bg-amber-50 text-amber-700 border border-amber-200'                                         ][$res->user->status_lulus] ?? 'bg-slate-100 text-slate-600';
                                    @endphp
                                    <span class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold uppercase tracking-wider {{ $statusClass }}">
                                        {{ str_replace('_', ' ', $res->user->status_lulus) }}
                                    </span>
                                </td>
                                <td class="p-5 text-center">
                                    <!-- Form Update Satuan -->
                                    <div class="inline-flex items-center">
                                        <select onchange="updateSingleStatus('{{ $res->user->id }}', this.value)" class="px-3.5 py-2.5 border border-slate-300 rounded-2xl text-xs font-bold focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 bg-white">
                                            <option value="pending" {{ $res->user->status_lulus == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="lolos" {{ $res->user->status_lulus == 'lolos' ? 'selected' : '' }}>Lolos</option>
                                            <option value="tidak_lolos" {{ $res->user->status_lulus == 'tidak_lolos' ? 'selected' : '' }}>Tidak Lolos</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-400 text-sm font-medium">
                                    Belum ada rekap hasil ujian siswa di dalam sistem.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>

    <!-- Script JavaScript untuk Checkbox Pilih Semua & Update Satuan -->
    <script>
        const selectAllCheckbox = document.getElementById('select-all');
        const studentCheckboxes = document.querySelectorAll('.student-checkbox');

        if (selectAllCheckbox) {
            selectAllCheckbox.addEventListener('change', function() {
                studentCheckboxes.forEach(cb => {
                    cb.checked = selectAllCheckbox.checked;
                });
            });
        }

        function updateSingleStatus(userId, status) {
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/students/${userId}/status`;

            let csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);

            let statusInput = document.createElement('input');
            statusInput.type = 'hidden';
            statusInput.name = 'status_lulus';
            statusInput.value = status;
            form.appendChild(statusInput);

            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endsection
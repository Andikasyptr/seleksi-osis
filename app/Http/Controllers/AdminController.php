<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Exam;
use App\Models\Question;
use App\Models\Option;
use App\Models\StudentExam;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;
use App\Exports\QuestionsTemplateExport; // Pastikan export ini di-use

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = User::where('role', 'student')->count();
        $totalExams = Exam::count();
        return view('admin.dashboard', compact('totalStudents', 'totalExams'));
    }

    // Kelola Akun Siswa
    public function students()
    {
        $students = User::where('role', 'student')->get();
        return view('admin.students', compact('students'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        return back()->with('success', 'Akun siswa berhasil dibuat.');
    }

    public function updateStudent(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'password' => 'nullable|string|min:6',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.students')->with('success', 'Akun siswa berhasil diperbarui.');
    }

    public function destroyStudent(User $user)
    {
        $user->delete();
        return redirect()->route('admin.students')->with('success', 'Akun siswa berhasil dihapus.');
    }

    // Kelola Jadwal Ujian
    public function exams()
    {
        $exams = Exam::all();
        return view('admin.exams', compact('exams'));
    }

    public function storeExam(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        Exam::create($request->all());

        return back()->with('success', 'Jadwal ujian berhasil ditambahkan.');
    }

    public function updateExam(Request $request, $examId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $exam = Exam::findOrFail($examId);
        $exam->update($request->all());

        return back()->with('success', 'Jadwal ujian berhasil diperbarui.');
    }

    public function destroyExam($examId)
    {
        $exam = Exam::findOrFail($examId);
        $exam->delete();

        return back()->with('success', 'Jadwal ujian berhasil dihapus.');
    }

    // Builder Soal & Opsi Pilihan Ganda
    public function builder($examId)
    {
        $exam = Exam::with('questions.options')->findOrFail($examId);
        return view('admin.builder', compact('exam'));
    }

    public function storeQuestion(Request $request, $examId)
    {
        $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|min:2',
            'points' => 'required|array',
        ]);

        $question = Question::create([
            'exam_id' => $examId,
            'question_text' => $request->question_text,
        ]);

        foreach ($request->options as $index => $optionText) {
            if (!empty($optionText)) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $optionText,
                    'points' => $request->points[$index] ?? 0,
                ]);
            }
        }

        return back()->with('success', 'Soal pilihan ganda berhasil ditambahkan.');
    }

    // Download Template Excel (.xlsx) untuk Import Soal
    public function downloadTemplate()
    {
        return Excel::download(new QuestionsTemplateExport, 'template_soal_osis.xlsx');
    }

    // Import Soal via Excel
    public function importExcel(Request $request, $examId)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new QuestionsImport($examId), $request->file('file'));
            return back()->with('success', 'Soal berhasil di-import dari file Excel!');
        } catch (\Exception $e) {
            return back()->withErrors(['file' => 'Gagal mengimpor file: ' . $e->getMessage()]);
        }
    }

    // Rekap Hasil Nilai & Status Kelulusan
    public function results()
    {
        $results = StudentExam::with(['user', 'exam'])->get();
        return view('admin.results', compact('results'));
    }

    public function updateStatus(Request $request, $userId)
    {
        $request->validate([
            'status_lulus' => 'required|in:pending,lolos,tidak_lolos'
        ]);

        $user = User::findOrFail($userId);
        $user->update(['status_lulus' => $request->status_lulus]);

        return back()->with('success', 'Status kelulusan siswa berhasil diperbarui.');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'status_lulus' => 'required|in:pending,lolos,tidak_lolos'
        ]);

        User::whereIn('id', $request->student_ids)->update([
            'status_lulus' => $request->status_lulus
        ]);

        return back()->with('success', 'Status kelulusan siswa terpilih berhasil diperbarui secara massal.');
    }
}
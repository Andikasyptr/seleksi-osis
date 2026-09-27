<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\StudentExam;
use App\Models\StudentAnswer;
use App\Models\Option;
use Carbon\Carbon;

class StudentController extends Controller
{
    // Halaman Beranda / Dashboard (Informasi, Timeline, & Pengumuman)
    public function dashboard()
    {
        $user = auth()->user();
        return view('student.dashboard', compact('user'));
    }

    // Halaman Menu Khusus Daftar Ujian Seleksi CAT
    public function examsIndex()
    {
        $user = auth()->user();
        $exams = Exam::all();
        $studentExams = StudentExam::where('user_id', $user->id)->get()->keyBy('exam_id');

        return view('student.exams', compact('exams', 'studentExams'));
    }

    public function examRoom($examId)
    {
        $exam = Exam::with('questions.options')->findOrFail($examId);
        $user = auth()->user();

        $studentExam = StudentExam::firstOrCreate(
            ['user_id' => $user->id, 'exam_id' => $examId],
            ['status' => 'sedang_mengerjakan', 'started_at' => Carbon::now()]
        );

        if ($studentExam->status === 'selesai') {
            return redirect()->route('student.exams')->with('error', 'Anda sudah menyelesaikan ujian ini.');
        }

        return view('student.exam-room', compact('exam', 'studentExam'));
    }

    public function submitExam(Request $request, $examId)
    {
        $user = auth()->user();
        $answers = $request->input('answers', []); // Format: [question_id => option_id]

        $totalScore = 0;
        foreach ($answers as $questionId => $optionId) {
            $option = Option::find($optionId);
            if ($option) {
                $totalScore += $option->points;
                
                // Diperbarui: Disimpan berdasarkan user_id dan question_id saja tanpa exam_id
                StudentAnswer::updateOrCreate(
                    [
                        'user_id' => $user->id, 
                        'question_id' => $questionId
                    ],
                    [
                        'option_id' => $optionId
                    ]
                );
            }
        }

        StudentExam::where('user_id', $user->id)->where('exam_id', $examId)->update([
            'total_score' => $totalScore,
            'status' => 'selesai',
            'submitted_at' => Carbon::now(),
        ]);

        return redirect()->route('student.exams')->with('success', 'Ujian berhasil dikumpulkan! Terima kasih.');
    }
}
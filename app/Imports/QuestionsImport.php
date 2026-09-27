<?php

namespace App\Imports;

use App\Models\Question;
use App\Models\Option;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\Model;

class QuestionsImport implements ToModel, WithHeadingRow
{
    protected $examId;

    public function __construct($examId)
    {
        $this->examId = $examId;
    }

    public function model(array $row): Model|array|null
    {
        // Pastikan baris memiliki teks soal
        if (empty($row['question_text'])) {
            return null;
        }

        // 1. Simpan Pertanyaan
        $question = Question::create([
            'exam_id' => $this->examId,
            'question_text' => $row['question_text'],
        ]);

        // 2. Daftar opsi yang diekstrak dari kolom Excel (A, B, C, D)
        $optionsData = [
            ['text' => $row['option_a'] ?? null, 'points' => $row['point_a'] ?? 0],
            ['text' => $row['option_b'] ?? null, 'points' => $row['point_b'] ?? 0],
            ['text' => $row['option_c'] ?? null, 'points' => $row['point_c'] ?? 0],
            ['text' => $row['option_d'] ?? null, 'points' => $row['point_d'] ?? 0],
        ];

        // 3. Simpan Opsi Jawaban jika teks opsi tidak kosong
        foreach ($optionsData as $opt) {
            if (!empty($opt['text'])) {
                Option::create([
                    'question_id' => $question->id,
                    'option_text' => $opt['text'],
                    'points' => (int) $opt['points'],
                ]);
            }
        }

        return $question;
    }
}
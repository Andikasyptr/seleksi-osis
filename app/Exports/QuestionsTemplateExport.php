<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class QuestionsTemplateExport implements FromCollection, WithHeadings
{
    public function headings(): array
    {
        return [
            'question_text', 
            'option_a', 
            'point_a', 
            'option_b', 
            'point_b', 
            'option_c', 
            'point_c', 
            'option_d', 
            'point_d'
        ];
    }

    public function collection(): Collection
    {
        // Memberikan 1 baris contoh data agar admin tahu format isinya
        return collect([
            [
                'question_text' => 'Apa kepanjangan dari OSIS?',
                'option_a' => 'Organisasi Siswa Intra Sekolah',
                'point_a' => 10,
                'option_b' => 'Organisasi Sekolah',
                'point_b' => 0,
                'option_c' => 'Organisasi Siswa',
                'point_c' => 0,
                'option_d' => 'Organisasi Siswa Indonesia',
                'point_d' => 0,
            ]
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    public function run()
    {
        $subjects = [
            [
                "name" => "Matematika",
                "code" => "MTK",
                "description" => "Mata pelajaran matematika untuk semua tingkat",
                "credit_hours" => 4
            ],
            [
                "name" => "Bahasa Indonesia", 
                "code" => "BIND",
                "description" => "Mata pelajaran bahasa Indonesia",
                "credit_hours" => 4
            ],
            [
                "name" => "Bahasa Inggris",
                "code" => "BING", 
                "description" => "Mata pelajaran bahasa Inggris",
                "credit_hours" => 3
            ],
            [
                "name" => "Ilmu Pengetahuan Alam",
                "code" => "IPA",
                "description" => "Mata pelajaran IPA (Fisika, Kimia, Biologi)",
                "credit_hours" => 4
            ],
            [
                "name" => "Ilmu Pengetahuan Sosial",
                "code" => "IPS", 
                "description" => "Mata pelajaran IPS (Sejarah, Geografi, Ekonomi)",
                "credit_hours" => 3
            ]
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ["code" => $subject["code"]],
                $subject
            );
        }
    }
}

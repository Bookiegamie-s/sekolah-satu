<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClassModel;

class ClassSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            [
                "name" => "Kelas 7A",
                "code" => "7A",
                "grade_level" => 7,
                "max_students" => 30,
                "description" => "Kelas 7A untuk tingkat SMP"
            ],
            [
                "name" => "Kelas 7B", 
                "code" => "7B",
                "grade_level" => 7,
                "max_students" => 30,
                "description" => "Kelas 7B untuk tingkat SMP"
            ],
            [
                "name" => "Kelas 8A",
                "code" => "8A",
                "grade_level" => 8,
                "max_students" => 30, 
                "description" => "Kelas 8A untuk tingkat SMP"
            ]
        ];

        foreach ($classes as $class) {
            ClassModel::firstOrCreate(
                ["code" => $class["code"]],
                $class
            );
        }
    }
}

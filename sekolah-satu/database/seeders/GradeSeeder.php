<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = Student::all();
        $subjects = Subject::all();

        if ($students->count() == 0) {
            $this->command->info('No students found. Please seed students first.');
            return;
        }

        if ($subjects->count() == 0) {
            // Create some basic subjects if none exist
            $subjectNames = [
                'Matematika',
                'Bahasa Indonesia', 
                'Bahasa Inggris',
                'IPA',
                'IPS',
                'Pendidikan Agama',
                'Olahraga',
                'Seni Budaya'
            ];

            foreach ($subjectNames as $name) {
                Subject::create([
                    'name' => $name,
                    'code' => strtoupper(substr($name, 0, 3)) . rand(100, 999),
                    'description' => 'Mata pelajaran ' . $name,
                    'credits' => 2,
                ]);
            }

            $subjects = Subject::all();
            $this->command->info('Created basic subjects.');
        }

        foreach ($students as $student) {
            // Create grades for current academic year
            $academicYear = '2024/2025';
            
            foreach ([1, 2] as $semester) {
                // Take random subjects for this semester
                $semesterSubjects = $subjects->random(rand(5, 7));
                
                foreach ($semesterSubjects as $subject) {
                    $assignmentScore = rand(70, 95);
                    $midtermScore = rand(70, 95);
                    $finalScore = rand(70, 95);
                    
                    // Calculate total score (weighted average)
                    $totalScore = round(($assignmentScore * 0.3) + ($midtermScore * 0.3) + ($finalScore * 0.4));
                    
                    // Determine grade
                    $grade = match(true) {
                        $totalScore >= 90 => 'A',
                        $totalScore >= 80 => 'B',
                        $totalScore >= 70 => 'C',
                        $totalScore >= 60 => 'D',
                        default => 'E'
                    };

                    Grade::create([
                        'student_id' => $student->id,
                        'subject_id' => $subject->id,
                        'academic_year' => $academicYear,
                        'semester' => $semester,
                        'assignment_score' => $assignmentScore,
                        'midterm_score' => $midtermScore,
                        'final_score' => $finalScore,
                        'total_score' => $totalScore,
                        'grade' => $grade,
                    ]);
                }
            }
        }

        $this->command->info('Grades seeded successfully!');
    }
}

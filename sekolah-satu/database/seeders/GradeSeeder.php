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
        $teachers = \App\Models\Teacher::all();

        if ($students->count() == 0) {
            $this->command->info('No students found. Please seed students first.');
            return;
        }

        if ($teachers->count() == 0) {
            $this->command->info('No teachers found. Please seed teachers first.');
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
                // Take random subjects for this semester (max available subjects)
                $maxSubjects = min($subjects->count(), 6);
                $subjectCount = rand(3, $maxSubjects);
                $semesterSubjects = $subjects->random($subjectCount);
                
                foreach ($semesterSubjects as $subject) {
                    // Create multiple assessment types for each subject
                    $assessmentTypes = ['assignment', 'midterm', 'final'];
                    $teacher = $teachers->random(); // Random teacher for this subject
                    
                    foreach ($assessmentTypes as $assessmentType) {
                        $score = rand(70, 95);
                        $maxScore = 100;

                        Grade::create([
                            'student_id' => $student->id,
                            'subject_id' => $subject->id,
                            'teacher_id' => $teacher->id,
                            'academic_year' => $academicYear,
                            'semester' => $semester,
                            'assessment_type' => $assessmentType,
                            'score' => $score,
                            'max_score' => $maxScore,
                            'notes' => 'Penilaian ' . $assessmentType . ' untuk ' . $subject->name,
                        ]);
                    }
                }
            }
        }

        $this->command->info('Grades seeded successfully!');
    }
}

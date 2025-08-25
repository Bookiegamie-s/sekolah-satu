<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ClassModel;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create admin user
        $admin = User::firstOrCreate([
            "email" => "admin@sekolah.com"
        ], [
            "name" => "Administrator",
            "email" => "admin@sekolah.com",
            "password" => Hash::make("password"),
            "phone" => "081234567890",
            "address" => "Jl. Admin No. 1",
            "birth_date" => "1980-01-01",
            "gender" => "male",
            "is_active" => true
        ]);
        $admin->assignRole("admin");

        // Create teachers
        $teachers = [
            [
                "name" => "Dr. Ahmad Guru",
                "email" => "ahmad@sekolah.com",
                "specialization" => "Matematika",
                "employee_id" => "GUR001"
            ],
            [
                "name" => "Siti Nurhaliza S.Pd",
                "email" => "siti@sekolah.com", 
                "specialization" => "Bahasa Indonesia",
                "employee_id" => "GUR002"
            ],
            [
                "name" => "John Smith M.Ed",
                "email" => "john@sekolah.com",
                "specialization" => "Bahasa Inggris", 
                "employee_id" => "GUR003"
            ],
            [
                "name" => "Dr. Budi Santoso",
                "email" => "budi@sekolah.com",
                "specialization" => "IPA",
                "employee_id" => "GUR004"
            ],
            [
                "name" => "Rina Susanti S.Sos",
                "email" => "rina@sekolah.com",
                "specialization" => "IPS",
                "employee_id" => "GUR005"
            ],
            [
                "name" => "Drs. Haryanto",
                "email" => "haryanto@sekolah.com",
                "specialization" => "Matematika",
                "employee_id" => "GUR006"
            ],
            [
                "name" => "Dewi Lestari S.Pd",
                "email" => "dewi@sekolah.com",
                "specialization" => "Bahasa Indonesia",
                "employee_id" => "GUR007"
            ],
            [
                "name" => "Michael Johnson",
                "email" => "michael@sekolah.com",
                "specialization" => "Bahasa Inggris",
                "employee_id" => "GUR008"
            ],
            [
                "name" => "Dr. Andi Wijaya",
                "email" => "andi@sekolah.com",
                "specialization" => "IPA",
                "employee_id" => "GUR009"
            ],
            [
                "name" => "Maya Sari S.Sos",
                "email" => "maya@sekolah.com",
                "specialization" => "IPS",
                "employee_id" => "GUR010"
            ]
        ];

        foreach ($teachers as $index => $teacherData) {
            $user = User::firstOrCreate([
                "email" => $teacherData["email"]
            ], [
                "name" => $teacherData["name"],
                "email" => $teacherData["email"],
                "password" => Hash::make("password"),
                "phone" => "0812345678" . sprintf("%02d", $index + 1),
                "address" => "Jl. Guru No. " . ($index + 1),
                "birth_date" => "198" . ($index % 10) . "-01-01",
                "gender" => $index % 2 == 0 ? "male" : "female",
                "is_active" => true
            ]);

            $user->assignRole("teacher");

            Teacher::firstOrCreate([
                "user_id" => $user->id
            ], [
                "user_id" => $user->id,
                "employee_id" => $teacherData["employee_id"],
                "specialization" => $teacherData["specialization"],
                "max_jam_mengajar" => 24,
                "hire_date" => "2020-01-01",
                "salary" => 5000000,
                "qualifications" => "S1 " . $teacherData["specialization"]
            ]);
        }

        // Create students
        $classes = ClassModel::all();
        $studentCounter = 1;

        foreach ($classes as $class) {
            for ($i = 1; $i <= 10; $i++) {
                $user = User::create([
                    "name" => "Siswa " . $studentCounter,
                    "email" => "siswa" . $studentCounter . "@sekolah.com",
                    "password" => Hash::make("password"),
                    "phone" => "0856789012" . sprintf("%02d", $studentCounter),
                    "address" => "Jl. Siswa No. " . $studentCounter,
                    "birth_date" => "200" . ($studentCounter % 9 + 1) . "-01-01",
                    "gender" => $studentCounter % 2 == 0 ? "male" : "female",
                    "is_active" => true
                ]);

                $user->assignRole("student");

                Student::create([
                    "user_id" => $user->id,
                    "class_id" => $class->id,
                    "student_id" => "SIS" . sprintf("%03d", $studentCounter),
                    "parent_name" => "Orang Tua " . $studentCounter,
                    "parent_phone" => "0817890123" . sprintf("%02d", $studentCounter),
                    "parent_address" => "Jl. Orang Tua No. " . $studentCounter,
                    "enrollment_date" => "2023-07-01",
                    "status" => "active"
                ]);

                $studentCounter++;
            }
        }
    }
}

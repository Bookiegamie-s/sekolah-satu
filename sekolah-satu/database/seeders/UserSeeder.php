<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            "name" => "Administrator",
            "email" => "admin@sekolah.test",
            "password" => Hash::make("password"),
            "email_verified_at" => now(),
        ]);
        $admin->assignRole("admin");

        // Create Teacher Users
        $teacher1 = User::create([
            "name" => "Budi Santoso",
            "email" => "budi@sekolah.test",
            "password" => Hash::make("password"),
            "phone" => "081234567890",
            "address" => "Jl. Pendidikan No. 1, Jakarta",
            "email_verified_at" => now(),
        ]);
        $teacher1->assignRole("teacher");

        Teacher::create([
            "user_id" => $teacher1->id,
            "employee_id" => "198501012010011001",
            "specialization" => "Matematika",
            "max_jam_mengajar" => 24,
            "hire_date" => "2020-01-01",
            "salary" => 5000000,
            "qualifications" => "S1 Pendidikan Matematika",
            "is_active" => true,
        ]);

        $teacher2 = User::create([
            "name" => "Siti Rahayu",
            "email" => "siti@sekolah.test", 
            "password" => Hash::make("password"),
            "phone" => "081234567891",
            "address" => "Jl. Pendidikan No. 2, Jakarta",
            "email_verified_at" => now(),
        ]);
        $teacher2->assignRole("teacher");

        Teacher::create([
            "user_id" => $teacher2->id,
            "employee_id" => "198502022011012002",
            "specialization" => "Bahasa Indonesia",
            "max_jam_mengajar" => 24,
            "hire_date" => "2020-02-01",
            "salary" => 5200000,
            "qualifications" => "S1 Pendidikan Bahasa Indonesia",
            "is_active" => true,
        ]);

        // Create Student Users
        $student1 = User::create([
            "name" => "Ahmad Fauzi",
            "email" => "ahmad@sekolah.test",
            "password" => Hash::make("password"),
            "phone" => "081234567892",
            "address" => "Jl. Siswa No. 1, Jakarta",
            "email_verified_at" => now(),
        ]);
        $student1->assignRole("student");

        Student::create([
            "user_id" => $student1->id,
            "class_id" => 1,
            "student_id" => "2024001001",
            "parent_name" => "Bapak Fauzi",
            "parent_phone" => "081234567800",
            "parent_address" => "Jl. Siswa No. 1, Jakarta",
            "enrollment_date" => "2024-07-01",
            "status" => "active",
        ]);

        $student2 = User::create([
            "name" => "Dewi Lestari",
            "email" => "dewi@sekolah.test",
            "password" => Hash::make("password"),
            "phone" => "081234567893",
            "address" => "Jl. Siswa No. 2, Jakarta",
            "email_verified_at" => now(),
        ]);
        $student2->assignRole("student");

        Student::create([
            "user_id" => $student2->id,
            "class_id" => 1,
            "student_id" => "2024001002",
            "parent_name" => "Ibu Lestari",
            "parent_phone" => "081234567801",
            "parent_address" => "Jl. Siswa No. 2, Jakarta",
            "enrollment_date" => "2024-07-01",
            "status" => "active",
        ]);

        // Create Library Staff
        $librarian = User::create([
            "name" => "Pustakawan",
            "email" => "library@sekolah.test",
            "password" => Hash::make("password"),
            "phone" => "081234567894",
            "address" => "Jl. Perpustakaan No. 1, Jakarta",
            "email_verified_at" => now(),
        ]);
        $librarian->assignRole("library_staff");
    }
}

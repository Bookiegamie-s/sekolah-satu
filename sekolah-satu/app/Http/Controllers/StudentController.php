<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\User;
use App\Models\ClassModel;
use App\Http\Requests\StudentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::with(["user", "class"])
                       ->when($request->search, function($q) use ($request) {
                           $q->whereHas("user", function($user) use ($request) {
                               $user->where("name", "like", "%{$request->search}%")
                                   ->orWhere("email", "like", "%{$request->search}%");
                           })
                           ->orWhere("student_id", "like", "%{$request->search}%");
                       })
                       ->when($request->class_id, function($q) use ($request) {
                           $q->where("class_id", $request->class_id);
                       })
                       ->when($request->status, function($q) use ($request) {
                           $q->where("status", $request->status);
                       });

        $students = $query->paginate(15);
        $classes = ClassModel::where("is_active", true)->get();

        return view("students.index", compact("students", "classes"));
    }

    public function create()
    {
        $classes = ClassModel::where("is_active", true)->get();
        return view("students.create", compact("classes"));
    }

    public function store(StudentRequest $request)
    {
        DB::transaction(function() use ($request) {
            // Create user
            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "phone" => $request->phone,
                "address" => $request->address,
                "birth_date" => $request->birth_date,
                "gender" => $request->gender,
                "is_active" => true
            ]);

            // Assign student role
            $user->assignRole("student");

            // Create student
            Student::create([
                "user_id" => $user->id,
                "class_id" => $request->class_id,
                "student_id" => $request->student_id,
                "parent_name" => $request->parent_name,
                "parent_phone" => $request->parent_phone,
                "parent_address" => $request->parent_address,
                "enrollment_date" => $request->enrollment_date,
                "status" => "active"
            ]);
        });

        return redirect()->route("students.index")->with("success", "Siswa berhasil ditambahkan.");
    }

    public function show(Student $student)
    {
        $student->load(["user", "class", "grades.subject", "attendances"]);
        
        return view("students.show", compact("student"));
    }

    public function edit(Student $student)
    {
        $classes = ClassModel::where("is_active", true)->get();
        return view("students.edit", compact("student", "classes"));
    }

    public function update(StudentRequest $request, Student $student)
    {
        DB::transaction(function() use ($request, $student) {
            // Update user
            $userData = [
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "address" => $request->address,
                "birth_date" => $request->birth_date,
                "gender" => $request->gender
            ];

            if ($request->filled("password")) {
                $userData["password"] = Hash::make($request->password);
            }

            $student->user->update($userData);

            // Update student
            $student->update([
                "class_id" => $request->class_id,
                "student_id" => $request->student_id,
                "parent_name" => $request->parent_name,
                "parent_phone" => $request->parent_phone,
                "parent_address" => $request->parent_address,
                "enrollment_date" => $request->enrollment_date,
                "status" => $request->status
            ]);
        });

        return redirect()->route("students.index")->with("success", "Data siswa berhasil diupdate.");
    }

    public function destroy(Student $student)
    {
        DB::transaction(function() use ($student) {
            $student->user->delete(); // This will cascade delete the student
        });

        return redirect()->route("students.index")->with("success", "Siswa berhasil dihapus.");
    }

    public function exportGrades(Request $request)
    {
        // This will be implemented with Laravel Excel
        // For now, return a placeholder
        return back()->with("info", "Export nilai akan segera tersedia.");
    }
}

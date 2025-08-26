<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Http\Requests\TeacherRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::with("user")
                       ->when($request->search, function($q) use ($request) {
                           $q->whereHas("user", function($user) use ($request) {
                               $user->where("name", "like", "%{$request->search}%")
                                   ->orWhere("email", "like", "%{$request->search}%");
                           })
                           ->orWhere("employee_id", "like", "%{$request->search}%");
                       })
                       ->when($request->status, function($q) use ($request) {
                           $q->where("is_active", $request->status === "active");
                       });

        $teachers = $query->paginate(10);
        
        // Get subjects for filter
        $subjects = \App\Models\Subject::orderBy('name')->get();

        return view("teachers.index", compact("teachers", "subjects"));
    }

    public function create()
    {
        return view("teachers.create");
    }

    public function store(TeacherRequest $request)
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

            // Assign teacher role
            $user->assignRole("teacher");

            // Create teacher
            $teacher = Teacher::create([
                "user_id" => $user->id,
                "employee_id" => $request->employee_id,
                "specialization" => $request->specialization,
                "max_jam_mengajar" => $request->max_jam_mengajar,
                "hire_date" => $request->hire_date,
                "salary" => $request->salary,
                "qualifications" => $request->qualifications,
                "is_active" => true
            ]);
        });

        return redirect()->route("teachers.index")->with("success", "Guru berhasil ditambahkan.");
    }

    public function show(Teacher $teacher)
    {
        $teacher->load(["user", "schedules.class", "schedules.subject"]);
        
        return view("teachers.show", compact("teacher"));
    }

    public function edit(Teacher $teacher)
    {
        return view("teachers.edit", compact("teacher"));
    }

    public function update(TeacherRequest $request, Teacher $teacher)
    {
        DB::transaction(function() use ($request, $teacher) {
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

            $teacher->user->update($userData);

            // Update teacher
            $teacher->update([
                "employee_id" => $request->employee_id,
                "specialization" => $request->specialization,
                "max_jam_mengajar" => $request->max_jam_mengajar,
                "hire_date" => $request->hire_date,
                "salary" => $request->salary,
                "qualifications" => $request->qualifications,
                "is_active" => $request->boolean("is_active")
            ]);
        });

        return redirect()->route("teachers.index")->with("success", "Data guru berhasil diupdate.");
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function() use ($teacher) {
            $teacher->user->delete(); // This will cascade delete the teacher
        });

        return redirect()->route("teachers.index")->with("success", "Guru berhasil dihapus.");
    }

    public function getTeachingHours(Teacher $teacher)
    {
        $currentHours = $teacher->getCurrentTeachingHours();
        $maxHours = $teacher->max_jam_mengajar;
        
        return response()->json([
            "current_hours" => $currentHours,
            "max_hours" => $maxHours,
            "remaining_hours" => $maxHours - $currentHours,
            "is_over_limit" => $currentHours > $maxHours
        ]);
    }
}

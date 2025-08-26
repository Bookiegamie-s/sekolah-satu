<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClassController extends Controller
{
    public function index(Request $request)
    {
        $query = ClassModel::with(["homeroom_teacher", "students"]);

        if ($request->filled("search")) {
            $query->where("name", "like", "%" . $request->search . "%");
        }

        if ($request->filled("grade_level")) {
            $query->where("grade_level", $request->grade_level);
        }

        $classes = $query->paginate(20);
        
        return view("classes.index", compact("classes"));
    }

    public function create()
    {
        $teachers = Teacher::with("user")
            ->whereDoesntHave("homeroom_class")
            ->where("status", "active")
            ->get();

        return view("classes.create", compact("teachers"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:100", "unique:classes,name"],
            "grade" => ["required", "integer", "min:1", "max:12"],
            "academic_year" => ["required", "string", "max:9"],
            "max_students" => ["required", "integer", "min:1", "max:50"],
            "homeroom_teacher_id" => ["nullable", "exists:teachers,id"],
            "description" => ["nullable", "string"],
        ]);

        $class = ClassModel::create($validated);

        return redirect()
            ->route("classes.index")
            ->with("success", "Kelas berhasil ditambahkan.");
    }

    public function show(ClassModel $class)
    {
        $class->load([
            "homeroom_teacher.user",
            "students.user",
            "schedules.subject",
            "schedules.teacher.user"
        ]);

        return view("classes.show", compact("class"));
    }

    public function edit(ClassModel $class)
    {
        $teachers = Teacher::with("user")
            ->where(function($query) use ($class) {
                $query->whereDoesntHave("homeroom_class")
                      ->orWhere("id", $class->homeroom_teacher_id);
            })
            ->where("status", "active")
            ->get();

        return view("classes.edit", compact("class", "teachers"));
    }

    public function update(Request $request, ClassModel $class)
    {
        $validated = $request->validate([
            "name" => ["required", "string", "max:100", Rule::unique("classes")->ignore($class->id)],
            "grade" => ["required", "integer", "min:1", "max:12"],
            "academic_year" => ["required", "string", "max:9"],
            "max_students" => ["required", "integer", "min:1", "max:50"],
            "homeroom_teacher_id" => ["nullable", "exists:teachers,id"],
            "description" => ["nullable", "string"],
        ]);

        $class->update($validated);

        return redirect()
            ->route("classes.index")
            ->with("success", "Kelas berhasil diperbarui.");
    }

    public function destroy(ClassModel $class)
    {
        if ($class->students()->count() > 0) {
            return redirect()
                ->route("classes.index")
                ->with("error", "Tidak dapat menghapus kelas yang masih memiliki siswa.");
        }

        $class->delete();

        return redirect()
            ->route("classes.index")
            ->with("success", "Kelas berhasil dihapus.");
    }

    public function students(ClassModel $class)
    {
        $class->load(["students.user"]);
        
        return view("classes.students", compact("class"));
    }

    public function schedules(ClassModel $class)
    {
        $schedules = $class->schedules()
            ->with(["subject", "teacher.user"])
            ->orderBy("day_of_week")
            ->orderBy("start_time")
            ->get()
            ->groupBy("day_of_week");

        $days = [
            1 => "Senin",
            2 => "Selasa", 
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu"
        ];

        return view("classes.schedules", compact("class", "schedules", "days"));
    }
}

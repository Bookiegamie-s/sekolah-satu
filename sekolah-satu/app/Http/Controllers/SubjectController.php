<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Subject::with(["teachers.user"]);

        if ($request->filled("search")) {
            $query->where(function($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%")
                  ->orWhere("code", "like", "%" . $request->search . "%");
            });
        }

        if ($request->filled("category")) {
            $query->where("category", $request->category);
        }

        $subjects = $query->paginate(20);
        
        return view("subjects.index", compact("subjects"));
    }

    public function create()
    {
        $teachers = Teacher::with("user")->where("status", "active")->get();
        
        return view("subjects.create", compact("teachers"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "code" => ["required", "string", "max:10", "unique:subjects,code"],
            "name" => ["required", "string", "max:100"],
            "description" => ["nullable", "string"],
            "category" => ["required", "in:core,elective,extracurricular"],
            "credits" => ["required", "integer", "min:1", "max:6"],
            "grade_level" => ["required", "integer", "min:1", "max:12"],
            "teachers" => ["array"],
            "teachers.*" => ["exists:teachers,id"],
        ]);

        $subject = Subject::create($validated);

        if ($request->filled("teachers")) {
            $subject->teachers()->attach($request->teachers);
        }

        return redirect()
            ->route("subjects.index")
            ->with("success", "Mata pelajaran berhasil ditambahkan.");
    }

    public function show(Subject $subject)
    {
        $subject->load([
            "teachers.user",
            "schedules.class",
            "schedules.teacher.user",
            "grades.student.user"
        ]);

        return view("subjects.show", compact("subject"));
    }

    public function edit(Subject $subject)
    {
        $teachers = Teacher::with("user")->where("status", "active")->get();
        $subject->load("teachers");
        
        return view("subjects.edit", compact("subject", "teachers"));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            "code" => ["required", "string", "max:10", Rule::unique("subjects")->ignore($subject->id)],
            "name" => ["required", "string", "max:100"],
            "description" => ["nullable", "string"],
            "category" => ["required", "in:core,elective,extracurricular"],
            "credits" => ["required", "integer", "min:1", "max:6"],
            "grade_level" => ["required", "integer", "min:1", "max:12"],
            "teachers" => ["array"],
            "teachers.*" => ["exists:teachers,id"],
        ]);

        $subject->update($validated);

        if ($request->has("teachers")) {
            $subject->teachers()->sync($request->teachers);
        }

        return redirect()
            ->route("subjects.index")
            ->with("success", "Mata pelajaran berhasil diperbarui.");
    }

    public function destroy(Subject $subject)
    {
        if ($subject->schedules()->count() > 0) {
            return redirect()
                ->route("subjects.index")
                ->with("error", "Tidak dapat menghapus mata pelajaran yang masih memiliki jadwal.");
        }

        if ($subject->grades()->count() > 0) {
            return redirect()
                ->route("subjects.index")
                ->with("error", "Tidak dapat menghapus mata pelajaran yang masih memiliki nilai.");
        }

        $subject->teachers()->detach();
        $subject->delete();

        return redirect()
            ->route("subjects.index")
            ->with("success", "Mata pelajaran berhasil dihapus.");
    }

    public function teachers(Subject $subject)
    {
        $subject->load(["teachers.user"]);
        $availableTeachers = Teacher::with("user")
            ->where("status", "active")
            ->whereDoesntHave("subjects", function($query) use ($subject) {
                $query->where("subject_id", $subject->id);
            })
            ->get();

        return view("subjects.teachers", compact("subject", "availableTeachers"));
    }

    public function addTeacher(Request $request, Subject $subject)
    {
        $request->validate([
            "teacher_id" => ["required", "exists:teachers,id"],
        ]);

        if (!$subject->teachers()->where("teacher_id", $request->teacher_id)->exists()) {
            $subject->teachers()->attach($request->teacher_id);
        }

        return redirect()
            ->route("subjects.teachers", $subject)
            ->with("success", "Guru berhasil ditambahkan ke mata pelajaran.");
    }

    public function removeTeacher(Subject $subject, Teacher $teacher)
    {
        $subject->teachers()->detach($teacher->id);

        return redirect()
            ->route("subjects.teachers", $subject)
            ->with("success", "Guru berhasil dihapus dari mata pelajaran.");
    }
}

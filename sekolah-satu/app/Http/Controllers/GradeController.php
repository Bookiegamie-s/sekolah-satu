<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    public function index(Request $request)
    {
        $query = Grade::with(["student.user", "subject", "student.schoolClass"]);

        if ($request->filled("class_id")) {
            $query->whereHas("student", function($q) use ($request) {
                $q->where("class_id", $request->class_id);
            });
        }

        if ($request->filled("subject_id")) {
            $query->where("subject_id", $request->subject_id);
        }

        if ($request->filled("semester")) {
            $query->where("semester", $request->semester);
        }

        if ($request->filled("academic_year")) {
            $query->where("academic_year", $request->academic_year);
        }

        if ($request->filled("search")) {
            $query->whereHas("student.user", function($q) use ($request) {
                $q->where("name", "like", "%" . $request->search . "%");
            });
        }

        $grades = $query->orderBy("academic_year", "desc")
                       ->orderBy("semester", "desc")
                       ->paginate(20);

        $classes = SchoolClass::orderBy("grade")->orderBy("name")->get();
        $subjects = Subject::orderBy("name")->get();

        return view("grades.index", compact("grades", "classes", "subjects"));
    }

    public function create(Request $request)
    {
        $classes = SchoolClass::orderBy("grade")->orderBy("name")->get();
        $subjects = Subject::orderBy("name")->get();
        
        $students = collect();
        if ($request->filled("class_id")) {
            $students = Student::with("user")
                ->where("class_id", $request->class_id)
                ->where("status", "active")
                ->orderBy("nis")
                ->get();
        }

        return view("grades.create", compact("classes", "subjects", "students"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "student_id" => ["required", "exists:students,id"],
            "subject_id" => ["required", "exists:subjects,id"],
            "semester" => ["required", "in:1,2"],
            "academic_year" => ["required", "string", "max:9"],
            "assignment_score" => ["nullable", "numeric", "min:0", "max:100"],
            "quiz_score" => ["nullable", "numeric", "min:0", "max:100"],
            "midterm_score" => ["nullable", "numeric", "min:0", "max:100"],
            "final_score" => ["nullable", "numeric", "min:0", "max:100"],
            "notes" => ["nullable", "string"],
        ]);

        // Check if grade already exists
        $existingGrade = Grade::where("student_id", $validated["student_id"])
            ->where("subject_id", $validated["subject_id"])
            ->where("semester", $validated["semester"])
            ->where("academic_year", $validated["academic_year"])
            ->first();

        if ($existingGrade) {
            return back()
                ->withInput()
                ->withErrors(["duplicate" => "Nilai untuk siswa ini pada mata pelajaran dan semester yang sama sudah ada."]);
        }

        Grade::create($validated);

        return redirect()
            ->route("grades.index")
            ->with("success", "Nilai berhasil ditambahkan.");
    }

    public function show(Grade $grade)
    {
        $grade->load(["student.user", "student.schoolClass", "subject"]);
        
        return view("grades.show", compact("grade"));
    }

    public function edit(Grade $grade)
    {
        $grade->load(["student.user", "student.schoolClass", "subject"]);
        
        return view("grades.edit", compact("grade"));
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            "assignment_score" => ["nullable", "numeric", "min:0", "max:100"],
            "quiz_score" => ["nullable", "numeric", "min:0", "max:100"],
            "midterm_score" => ["nullable", "numeric", "min:0", "max:100"],
            "final_score" => ["nullable", "numeric", "min:0", "max:100"],
            "notes" => ["nullable", "string"],
        ]);

        $grade->update($validated);

        return redirect()
            ->route("grades.index")
            ->with("success", "Nilai berhasil diperbarui.");
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()
            ->route("grades.index")
            ->with("success", "Nilai berhasil dihapus.");
    }

    public function bulk(Request $request)
    {
        $classes = SchoolClass::orderBy("grade")->orderBy("name")->get();
        $subjects = Subject::orderBy("name")->get();
        
        $students = collect();
        $selectedClass = null;
        $selectedSubject = null;

        if ($request->filled("class_id") && $request->filled("subject_id")) {
            $selectedClass = SchoolClass::find($request->class_id);
            $selectedSubject = Subject::find($request->subject_id);
            
            $students = Student::with(["user", "grades" => function($query) use ($request) {
                $query->where("subject_id", $request->subject_id)
                      ->where("semester", $request->semester ?? 1)
                      ->where("academic_year", $request->academic_year ?? date("Y"));
            }])
            ->where("class_id", $request->class_id)
            ->where("status", "active")
            ->orderBy("nis")
            ->get();
        }

        return view("grades.bulk", compact("classes", "subjects", "students", "selectedClass", "selectedSubject"));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            "class_id" => ["required", "exists:classes,id"],
            "subject_id" => ["required", "exists:subjects,id"],
            "semester" => ["required", "in:1,2"],
            "academic_year" => ["required", "string", "max:9"],
            "grades" => ["required", "array"],
            "grades.*.student_id" => ["required", "exists:students,id"],
            "grades.*.assignment_score" => ["nullable", "numeric", "min:0", "max:100"],
            "grades.*.quiz_score" => ["nullable", "numeric", "min:0", "max:100"],
            "grades.*.midterm_score" => ["nullable", "numeric", "min:0", "max:100"],
            "grades.*.final_score" => ["nullable", "numeric", "min:0", "max:100"],
            "grades.*.notes" => ["nullable", "string"],
        ]);

        DB::transaction(function() use ($validated) {
            foreach ($validated["grades"] as $gradeData) {
                $gradeData["subject_id"] = $validated["subject_id"];
                $gradeData["semester"] = $validated["semester"];
                $gradeData["academic_year"] = $validated["academic_year"];

                Grade::updateOrCreate([
                    "student_id" => $gradeData["student_id"],
                    "subject_id" => $gradeData["subject_id"],
                    "semester" => $gradeData["semester"],
                    "academic_year" => $gradeData["academic_year"],
                ], $gradeData);
            }
        });

        return redirect()
            ->route("grades.bulk", $request->only(["class_id", "subject_id", "semester", "academic_year"]))
            ->with("success", "Nilai berhasil disimpan.");
    }

    public function report(Request $request)
    {
        $classes = SchoolClass::orderBy("grade")->orderBy("name")->get();
        $students = collect();
        $selectedClass = null;

        if ($request->filled("class_id")) {
            $selectedClass = SchoolClass::find($request->class_id);
            
            $students = Student::with([
                "user",
                "grades" => function($query) use ($request) {
                    $query->with("subject")
                          ->where("semester", $request->semester ?? 1)
                          ->where("academic_year", $request->academic_year ?? date("Y"));
                }
            ])
            ->where("class_id", $request->class_id)
            ->where("status", "active")
            ->orderBy("nis")
            ->get();
        }

        return view("grades.report", compact("classes", "students", "selectedClass"));
    }

    public function transcript(Student $student)
    {
        $student->load([
            "user",
            "schoolClass",
            "grades.subject"
        ]);

        $gradesByYear = $student->grades
            ->groupBy("academic_year")
            ->map(function($yearGrades) {
                return $yearGrades->groupBy("semester");
            });

        return view("grades.transcript", compact("student", "gradesByYear"));
    }
}

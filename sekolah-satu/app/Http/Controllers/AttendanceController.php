<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("permission:view attendance")->only(["index", "show"]);
        $this->middleware("permission:create attendance")->only(["create", "store"]);
        $this->middleware("permission:edit attendance")->only(["edit", "update"]);
    }

    public function index(Request $request)
    {
        $query = Attendance::with(["student.user", "class", "subject", "teacher.user"])
                          ->when($request->class_id, function($q) use ($request) {
                              $q->where("class_id", $request->class_id);
                          })
                          ->when($request->subject_id, function($q) use ($request) {
                              $q->where("subject_id", $request->subject_id);
                          })
                          ->when($request->date, function($q) use ($request) {
                              $q->whereDate("date", $request->date);
                          })
                          ->when($request->status, function($q) use ($request) {
                              $q->where("status", $request->status);
                          });

        $attendances = $query->orderBy("date", "desc")->paginate(20);
        $classes = ClassModel::where("is_active", true)->get();
        $subjects = Subject::where("is_active", true)->get();

        return view("attendances.index", compact("attendances", "classes", "subjects"));
    }

    public function create(Request $request)
    {
        $classes = ClassModel::where("is_active", true)->get();
        $subjects = Subject::where("is_active", true)->get();
        
        $selectedClass = null;
        $selectedSubject = null;
        $students = collect();
        
        if ($request->class_id && $request->subject_id) {
            $selectedClass = ClassModel::find($request->class_id);
            $selectedSubject = Subject::find($request->subject_id);
            $students = Student::where("class_id", $request->class_id)
                              ->where("status", "active")
                              ->with("user")
                              ->get();
        }

        return view("attendances.create", compact(
            "classes", "subjects", "selectedClass", "selectedSubject", "students"
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            "class_id" => "required|exists:classes,id",
            "subject_id" => "required|exists:subjects,id",
            "date" => "required|date",
            "attendances" => "required|array",
            "attendances.*.student_id" => "required|exists:students,id",
            "attendances.*.status" => "required|in:present,absent,late,sick,permit",
            "attendances.*.notes" => "nullable|string"
        ]);

        $teacherId = auth()->user()->teacher?->id;
        
        if (!$teacherId) {
            return back()->with("error", "Hanya guru yang dapat melakukan absensi.");
        }

        DB::transaction(function() use ($request, $teacherId) {
            foreach ($request->attendances as $attendanceData) {
                Attendance::updateOrCreate(
                    [
                        "student_id" => $attendanceData["student_id"],
                        "class_id" => $request->class_id,
                        "subject_id" => $request->subject_id,
                        "date" => $request->date
                    ],
                    [
                        "teacher_id" => $teacherId,
                        "status" => $attendanceData["status"],
                        "notes" => $attendanceData["notes"] ?? null
                    ]
                );
            }
        });

        return redirect()->route("attendances.index")->with("success", "Absensi berhasil disimpan.");
    }

    public function show(Request $request)
    {
        $request->validate([
            "class_id" => "required|exists:classes,id",
            "subject_id" => "required|exists:subjects,id",
            "date" => "required|date"
        ]);

        $class = ClassModel::find($request->class_id);
        $subject = Subject::find($request->subject_id);
        
        $attendances = Attendance::with(["student.user"])
                                ->where("class_id", $request->class_id)
                                ->where("subject_id", $request->subject_id)
                                ->whereDate("date", $request->date)
                                ->get();

        return view("attendances.show", compact("attendances", "class", "subject"));
    }

    public function edit(Request $request)
    {
        $request->validate([
            "class_id" => "required|exists:classes,id",
            "subject_id" => "required|exists:subjects,id",
            "date" => "required|date"
        ]);

        $class = ClassModel::find($request->class_id);
        $subject = Subject::find($request->subject_id);
        
        $students = Student::where("class_id", $request->class_id)
                          ->where("status", "active")
                          ->with(["user", "attendances" => function($q) use ($request) {
                              $q->where("subject_id", $request->subject_id)
                                ->whereDate("date", $request->date);
                          }])
                          ->get();

        return view("attendances.edit", compact("students", "class", "subject"));
    }

    public function getStudentsByClass(Request $request)
    {
        $students = Student::where("class_id", $request->class_id)
                          ->where("status", "active")
                          ->with("user")
                          ->get();

        return response()->json($students);
    }

    public function getAttendanceReport(Request $request)
    {
        $request->validate([
            "class_id" => "required|exists:classes,id",
            "subject_id" => "required|exists:subjects,id",
            "start_date" => "required|date",
            "end_date" => "required|date|after_or_equal:start_date"
        ]);

        $attendances = Attendance::with(["student.user"])
                                ->where("class_id", $request->class_id)
                                ->where("subject_id", $request->subject_id)
                                ->whereBetween("date", [$request->start_date, $request->end_date])
                                ->get()
                                ->groupBy("student_id");

        $report = [];
        foreach ($attendances as $studentId => $studentAttendances) {
            $student = $studentAttendances->first()->student;
            $report[] = [
                "student" => $student,
                "total" => $studentAttendances->count(),
                "present" => $studentAttendances->where("status", "present")->count(),
                "absent" => $studentAttendances->where("status", "absent")->count(),
                "late" => $studentAttendances->where("status", "late")->count(),
                "sick" => $studentAttendances->where("status", "sick")->count(),
                "permit" => $studentAttendances->where("status", "permit")->count(),
            ];
        }

        return response()->json($report);
    }
}

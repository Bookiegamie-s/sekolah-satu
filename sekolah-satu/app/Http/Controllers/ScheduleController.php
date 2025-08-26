<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(["class", "subject", "teacher.user"]);

        if ($request->filled("class_id")) {
            $query->where("class_id", $request->class_id);
        }

        if ($request->filled("teacher_id")) {
            $query->where("teacher_id", $request->teacher_id);
        }

        if ($request->filled("day")) {
            $query->where("day_of_week", $request->day);
        }

        $schedules = $query->orderBy("day_of_week")
                          ->orderBy("start_time")
                          ->paginate(20);

        $classes = ClassModel::orderBy("grade_level")->orderBy("name")->get();
        $teachers = Teacher::with("user")->where("is_active", true)->get();

        $days = [
            1 => "Senin",
            2 => "Selasa",
            3 => "Rabu", 
            4 => "Kamis",
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu"
        ];

        return view("schedules.index", compact("schedules", "classes", "teachers", "days"));
    }

    public function create()
    {
        $classes = ClassModel::orderBy("grade_level")->orderBy("name")->get();
        $subjects = Subject::orderBy("name")->get();
        $teachers = Teacher::with("user")->where("status", "active")->get();

        $days = [
            1 => "Senin",
            2 => "Selasa",
            3 => "Rabu",
            4 => "Kamis", 
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu"
        ];

        return view("schedules.create", compact("classes", "subjects", "teachers", "days"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "class_id" => ["required", "exists:classes,id"],
            "subject_id" => ["required", "exists:subjects,id"],
            "teacher_id" => ["required", "exists:teachers,id"],
            "day_of_week" => ["required", "integer", "min:1", "max:7"],
            "start_time" => ["required", "date_format:H:i"],
            "end_time" => ["required", "date_format:H:i", "after:start_time"],
            "room" => ["nullable", "string", "max:50"],
        ]);

        // Check for schedule conflicts
        $conflicts = $this->checkConflicts($validated);
        if (!empty($conflicts)) {
            return back()
                ->withInput()
                ->withErrors(["conflict" => "Terdapat konflik jadwal: " . implode(", ", $conflicts)]);
        }

        // Check teacher teaching hours
        $teacher = Teacher::find($validated["teacher_id"]);
        $teachingHours = $this->calculateTeachingHours($teacher, $validated);
        
        if ($teachingHours > $teacher->max_teaching_hours) {
            return back()
                ->withInput()
                ->withErrors(["teaching_hours" => "Guru melebihi batas maksimal jam mengajar ({$teacher->max_teaching_hours} jam)."]);
        }

        Schedule::create($validated);

        return redirect()
            ->route("schedules.index")
            ->with("success", "Jadwal berhasil ditambahkan.");
    }

    public function show(Schedule $schedule)
    {
        $schedule->load(["class", "subject", "teacher.user"]);
        
        return view("schedules.show", compact("schedule"));
    }

    public function edit(Schedule $schedule)
    {
        $classes = ClassModel::orderBy("grade_level")->orderBy("name")->get();
        $subjects = Subject::orderBy("name")->get();
        $teachers = Teacher::with("user")->where("status", "active")->get();

        $days = [
            1 => "Senin",
            2 => "Selasa",
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jumat", 
            6 => "Sabtu",
            7 => "Minggu"
        ];

        return view("schedules.edit", compact("schedule", "classes", "subjects", "teachers", "days"));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            "class_id" => ["required", "exists:classes,id"],
            "subject_id" => ["required", "exists:subjects,id"],
            "teacher_id" => ["required", "exists:teachers,id"],
            "day_of_week" => ["required", "integer", "min:1", "max:7"],
            "start_time" => ["required", "date_format:H:i"],
            "end_time" => ["required", "date_format:H:i", "after:start_time"],
            "room" => ["nullable", "string", "max:50"],
        ]);

        // Check for schedule conflicts (excluding current schedule)
        $conflicts = $this->checkConflicts($validated, $schedule->id);
        if (!empty($conflicts)) {
            return back()
                ->withInput()
                ->withErrors(["conflict" => "Terdapat konflik jadwal: " . implode(", ", $conflicts)]);
        }

        // Check teacher teaching hours
        $teacher = Teacher::find($validated["teacher_id"]);
        $teachingHours = $this->calculateTeachingHours($teacher, $validated, $schedule->id);
        
        if ($teachingHours > $teacher->max_teaching_hours) {
            return back()
                ->withInput()
                ->withErrors(["teaching_hours" => "Guru melebihi batas maksimal jam mengajar ({$teacher->max_teaching_hours} jam)."]);
        }

        $schedule->update($validated);

        return redirect()
            ->route("schedules.index")
            ->with("success", "Jadwal berhasil diperbarui.");
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route("schedules.index")
            ->with("success", "Jadwal berhasil dihapus.");
    }

    public function weekly(Request $request)
    {
        $classId = $request->class_id;
        $teacherId = $request->teacher_id;

        $query = Schedule::with(["class", "subject", "teacher.user"]);

        if ($classId) {
            $query->where("class_id", $classId);
        }

        if ($teacherId) {
            $query->where("teacher_id", $teacherId);
        }

        $schedules = $query->orderBy("day_of_week")
                          ->orderBy("start_time")
                          ->get()
                          ->groupBy("day_of_week");

        $classes = ClassModel::orderBy("grade_level")->orderBy("name")->get();
        $teachers = Teacher::with("user")->where("status", "active")->get();

        $days = [
            1 => "Senin",
            2 => "Selasa", 
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu"
        ];

        $timeSlots = [
            "07:00" => "07:00 - 07:45",
            "07:45" => "07:45 - 08:30",
            "08:30" => "08:30 - 09:15",
            "09:15" => "09:15 - 10:00",
            "10:15" => "10:15 - 11:00",
            "11:00" => "11:00 - 11:45",
            "11:45" => "11:45 - 12:30",
            "13:00" => "13:00 - 13:45",
            "13:45" => "13:45 - 14:30",
            "14:30" => "14:30 - 15:15",
        ];

        return view("schedules.weekly", compact("schedules", "classes", "teachers", "days", "timeSlots", "classId", "teacherId"));
    }

    private function checkConflicts(array $data, $excludeId = null)
    {
        $conflicts = [];

        // Check teacher conflict
        $teacherConflict = Schedule::where("teacher_id", $data["teacher_id"])
            ->where("day_of_week", $data["day_of_week"])
            ->where(function($query) use ($data) {
                $query->whereBetween("start_time", [$data["start_time"], $data["end_time"]])
                      ->orWhereBetween("end_time", [$data["start_time"], $data["end_time"]])
                      ->orWhere(function($q) use ($data) {
                          $q->where("start_time", "<=", $data["start_time"])
                            ->where("end_time", ">=", $data["end_time"]);
                      });
            });

        if ($excludeId) {
            $teacherConflict->where("id", "!=", $excludeId);
        }

        if ($teacherConflict->exists()) {
            $conflicts[] = "Guru sudah mengajar di waktu yang sama";
        }

        // Check class conflict
        $classConflict = Schedule::where("class_id", $data["class_id"])
            ->where("day_of_week", $data["day_of_week"])
            ->where(function($query) use ($data) {
                $query->whereBetween("start_time", [$data["start_time"], $data["end_time"]])
                      ->orWhereBetween("end_time", [$data["start_time"], $data["end_time"]])
                      ->orWhere(function($q) use ($data) {
                          $q->where("start_time", "<=", $data["start_time"])
                            ->where("end_time", ">=", $data["end_time"]);
                      });
            });

        if ($excludeId) {
            $classConflict->where("id", "!=", $excludeId);
        }

        if ($classConflict->exists()) {
            $conflicts[] = "Kelas sudah memiliki jadwal di waktu yang sama";
        }

        return $conflicts;
    }

    private function calculateTeachingHours(Teacher $teacher, array $newSchedule, $excludeId = null)
    {
        $query = Schedule::where("teacher_id", $teacher->id);
        
        if ($excludeId) {
            $query->where("id", "!=", $excludeId);
        }

        $existingSchedules = $query->get();
        
        $totalHours = 0;
        
        foreach ($existingSchedules as $schedule) {
            $start = \Carbon\Carbon::createFromFormat("H:i:s", $schedule->start_time);
            $end = \Carbon\Carbon::createFromFormat("H:i:s", $schedule->end_time);
            $totalHours += $end->diffInMinutes($start) / 60;
        }

        // Add new schedule hours
        $start = \Carbon\Carbon::createFromFormat("H:i", $newSchedule["start_time"]);
        $end = \Carbon\Carbon::createFromFormat("H:i", $newSchedule["end_time"]);
        $totalHours += $end->diffInMinutes($start) / 60;

        return $totalHours;
    }

    /**
     * Show schedule for authenticated user (student or teacher)
     */
    public function mySchedule()
    {
        $user = auth()->user();
        
        if ($user->hasRole('student') && $user->student) {
            // Student schedule
            $student = $user->student;
            
            if (!$student->class) {
                return redirect()->route('dashboard')->with('error', 'Anda belum terdaftar di kelas manapun.');
            }
            
            $schedules = Schedule::with(['subject', 'teacher.user'])
                ->where('class_id', $student->class_id)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();
            
            $title = 'Jadwal Kelas ' . $student->class->name;
            
        } elseif ($user->hasRole('teacher') && $user->teacher) {
            // Teacher schedule
            $teacher = $user->teacher;
            
            $schedules = Schedule::with(['class', 'subject'])
                ->where('teacher_id', $teacher->id)
                ->orderBy('day_of_week')
                ->orderBy('start_time')
                ->get();
            
            $title = 'Jadwal Mengajar Saya';
            
        } else {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses untuk melihat jadwal.');
        }
        
        $days = [
            1 => "Senin",
            2 => "Selasa", 
            3 => "Rabu",
            4 => "Kamis",
            5 => "Jumat",
            6 => "Sabtu",
            7 => "Minggu"
        ];
        
        return view('schedules.my-schedule', compact('schedules', 'days', 'title'));
    }
}

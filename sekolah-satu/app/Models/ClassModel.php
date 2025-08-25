<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = "classes";

    protected $fillable = [
        "name",
        "code",
        "grade_level",
        "max_students",
        "description",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean"
    ];

    // Relationships
    public function students()
    {
        return $this->hasMany(Student::class, "class_id");
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, "teacher_class_subject")
                    ->withPivot("subject_id")
                    ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, "teacher_class_subject")
                    ->withPivot("teacher_id")
                    ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, "class_id");
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, "class_id");
    }

    // Helper methods
    public function getStudentCountAttribute()
    {
        return $this->students()->count();
    }

    public function hasAvailableSlots()
    {
        return $this->student_count < $this->max_students;
    }
}

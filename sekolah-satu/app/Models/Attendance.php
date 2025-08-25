<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "class_id",
        "subject_id",
        "teacher_id",
        "date",
        "status",
        "notes"
    ];

    protected $casts = [
        "date" => "date"
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, "class_id");
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Scopes
    public function scopeByDate($query, $date)
    {
        return $query->where("date", $date);
    }

    public function scopeByClass($query, $classId)
    {
        return $query->where("class_id", $classId);
    }

    public function scopeBySubject($query, $subjectId)
    {
        return $query->where("subject_id", $subjectId);
    }

    public function scopePresent($query)
    {
        return $query->where("status", "present");
    }

    public function scopeAbsent($query)
    {
        return $query->whereIn("status", ["absent", "late", "sick", "permit"]);
    }
}

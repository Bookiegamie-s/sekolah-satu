<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "class_id",
        "student_id",
        "parent_name",
        "parent_phone",
        "parent_address",
        "enrollment_date",
        "status"
    ];

    protected $casts = [
        "enrollment_date" => "date"
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, "class_id");
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    public function subjects()
    {
        return $this->hasManyThrough(
            Subject::class,
            "teacher_class_subject",
            "class_id",
            "id",
            "class_id",
            "subject_id"
        );
    }

    // Helper methods
    public function getAttendancePercentage($subjectId = null)
    {
        $query = $this->attendances();
        
        if ($subjectId) {
            $query->where("subject_id", $subjectId);
        }
        
        $totalAttendances = $query->count();
        $presentAttendances = $query->where("status", "present")->count();
        
        return $totalAttendances > 0 ? ($presentAttendances / $totalAttendances) * 100 : 0;
    }

    public function getAverageGrade($subjectId = null)
    {
        $query = $this->grades();
        
        if ($subjectId) {
            $query->where("subject_id", $subjectId);
        }
        
        return $query->avg("score") ?? 0;
    }
}

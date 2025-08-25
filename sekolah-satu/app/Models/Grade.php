<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = [
        "student_id",
        "subject_id", 
        "teacher_id",
        "semester",
        "academic_year",
        "assessment_type",
        "score",
        "max_score",
        "notes"
    ];

    protected $casts = [
        "score" => "decimal:2",
        "max_score" => "decimal:2"
    ];

    // Relationships
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    // Helper methods
    public function getPercentageAttribute()
    {
        return ($this->score / $this->max_score) * 100;
    }

    public function getGradeLetterAttribute()
    {
        $percentage = $this->percentage;
        
        if ($percentage >= 90) return "A";
        if ($percentage >= 80) return "B";
        if ($percentage >= 70) return "C";
        if ($percentage >= 60) return "D";
        return "F";
    }

    // Scopes
    public function scopeBySemester($query, $semester)
    {
        return $query->where("semester", $semester);
    }

    public function scopeByAcademicYear($query, $academicYear)
    {
        return $query->where("academic_year", $academicYear);
    }

    public function scopeByAssessmentType($query, $type)
    {
        return $query->where("assessment_type", $type);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "code",
        "description", 
        "credit_hours",
        "is_active"
    ];

    protected $casts = [
        "is_active" => "boolean"
    ];

    // Relationships
    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, "teacher_class_subject")
                    ->withPivot("class_id")
                    ->withTimestamps();
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, "teacher_class_subject")
                    ->withPivot("teacher_id")
                    ->withTimestamps();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

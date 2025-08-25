<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "employee_id",
        "specialization",
        "max_jam_mengajar",
        "hire_date",
        "salary",
        "qualifications",
        "is_active"
    ];

    protected $casts = [
        "hire_date" => "date",
        "salary" => "decimal:2",
        "is_active" => "boolean"
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, "teacher_class_subject")
                    ->withPivot("subject_id")
                    ->withTimestamps();
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, "teacher_class_subject")
                    ->withPivot("class_id")
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

    // Helper methods
    public function getTotalJamMengajarAttribute()
    {
        return $this->schedules()
                    ->selectRaw("SUM(TIMESTAMPDIFF(HOUR, start_time, end_time)) as total")
                    ->where("is_active", true)
                    ->value("total") ?? 0;
    }

    public function canAddMoreHours($additionalHours)
    {
        return ($this->total_jam_mengajar + $additionalHours) <= $this->max_jam_mengajar;
    }

    public function getAvailableHoursAttribute()
    {
        return $this->max_jam_mengajar - $this->total_jam_mengajar;
    }
}

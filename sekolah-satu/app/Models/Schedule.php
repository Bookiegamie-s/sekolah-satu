<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        "teacher_id",
        "class_id",
        "subject_id",
        "day_of_week",
        "start_time",
        "end_time", 
        "room",
        "is_active"
    ];

    protected $casts = [
        "start_time" => "datetime:H:i",
        "end_time" => "datetime:H:i",
        "is_active" => "boolean"
    ];

    // Relationships
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, "class_id");
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // Helper methods
    public function getDurationInHoursAttribute()
    {
        $start = \Carbon\Carbon::parse($this->start_time);
        $end = \Carbon\Carbon::parse($this->end_time);
        return $end->diffInHours($start);
    }

    public function hasConflict($teacherId, $dayOfWeek, $startTime, $endTime, $excludeId = null)
    {
        $query = self::where("teacher_id", $teacherId)
                    ->where("day_of_week", $dayOfWeek)
                    ->where("is_active", true)
                    ->where(function($q) use ($startTime, $endTime) {
                        $q->where(function($q2) use ($startTime, $endTime) {
                            $q2->where("start_time", "<=", $startTime)
                               ->where("end_time", ">", $startTime);
                        })->orWhere(function($q2) use ($startTime, $endTime) {
                            $q2->where("start_time", "<", $endTime)
                               ->where("end_time", ">=", $endTime);
                        })->orWhere(function($q2) use ($startTime, $endTime) {
                            $q2->where("start_time", ">=", $startTime)
                               ->where("end_time", "<=", $endTime);
                        });
                    });

        if ($excludeId) {
            $query->where("id", "!=", $excludeId);
        }

        return $query->exists();
    }
}

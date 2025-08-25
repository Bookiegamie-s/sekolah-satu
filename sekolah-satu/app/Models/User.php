<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        "name",
        "email", 
        "password",
        "phone",
        "address",
        "birth_date",
        "gender",
        "avatar",
        "is_active"
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "birth_date" => "date",
            "is_active" => "boolean"
        ];
    }

    // Relationships
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }

    public function bookLoans()
    {
        return $this->hasMany(BookLoan::class);
    }

    // Helper methods
    public function isAdmin()
    {
        return $this->hasRole("admin");
    }

    public function isTeacher()
    {
        return $this->hasRole("teacher");
    }

    public function isStudent()
    {
        return $this->hasRole("student");
    }
}

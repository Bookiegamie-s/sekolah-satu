<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(["admin", "teacher"]);
    }

    public function view(User $user, Student $student): bool
    {
        if ($user->hasAnyRole(["admin", "teacher"])) {
            return true;
        }

        // Students can only view their own profile
        if ($user->hasRole("student") && $user->student) {
            return $user->student->id === $student->id;
        }

        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function update(User $user, Student $student): bool
    {
        if ($user->hasRole("admin")) {
            return true;
        }

        // Students can update their own profile (limited fields)
        if ($user->hasRole("student") && $user->student) {
            return $user->student->id === $student->id;
        }

        return false;
    }

    public function delete(User $user, Student $student): bool
    {
        return $user->hasRole("admin");
    }

    public function viewGrades(User $user, Student $student): bool
    {
        if ($user->hasAnyRole(["admin", "teacher"])) {
            return true;
        }

        // Students can only view their own grades
        if ($user->hasRole("student") && $user->student) {
            return $user->student->id === $student->id;
        }

        return false;
    }

    public function viewAttendance(User $user, Student $student): bool
    {
        if ($user->hasAnyRole(["admin", "teacher"])) {
            return true;
        }

        // Students can only view their own attendance
        if ($user->hasRole("student") && $user->student) {
            return $user->student->id === $student->id;
        }

        return false;
    }
}

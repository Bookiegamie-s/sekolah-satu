<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Subject;

class SubjectPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student"]);
    }

    public function view(User $user, Subject $subject): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student"]);
    }

    public function create(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function update(User $user, Subject $subject): bool
    {
        return $user->hasRole("admin");
    }

    public function delete(User $user, Subject $subject): bool
    {
        return $user->hasRole("admin");
    }

    public function manageTeachers(User $user, Subject $subject): bool
    {
        return $user->hasRole("admin");
    }
}

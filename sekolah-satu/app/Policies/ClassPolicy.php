<?php

namespace App\Policies;

use App\Models\User;
use App\Models\ClassModel;

class ClassPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student"]);
    }

    public function view(User $user, ClassModel $class): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student"]);
    }

    public function create(User $user): bool
    {
        return $user->hasRole("admin");
    }

    public function update(User $user, ClassModel $class): bool
    {
        return $user->hasRole("admin");
    }

    public function delete(User $user, ClassModel $class): bool
    {
        return $user->hasRole("admin");
    }

    public function manageStudents(User $user, ClassModel $class): bool
    {
        return $user->hasRole("admin") || 
               ($user->hasRole("teacher") && 
                $user->teacher && 
                $user->teacher->id === $class->homeroom_teacher_id);
    }
}

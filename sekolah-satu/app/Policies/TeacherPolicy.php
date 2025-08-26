<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo("manage_teachers");
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("manage_teachers") || 
               ($user->hasRole("teacher") && $user->teacher->id === $teacher->id);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo("manage_teachers");
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("manage_teachers") ||
               ($user->hasRole("teacher") && $user->teacher->id === $teacher->id);
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("manage_teachers");
    }

    public function restore(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("manage_teachers");
    }

    public function forceDelete(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("manage_teachers");
    }
}

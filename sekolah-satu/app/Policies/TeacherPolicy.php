<?php

namespace App\Policies;

use App\Models\Teacher;
use App\Models\User;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo("view teachers");
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("view teachers") || 
               ($user->hasRole("teacher") && $user->teacher->id === $teacher->id);
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo("create teachers");
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("edit teachers") ||
               ($user->hasRole("teacher") && $user->teacher->id === $teacher->id);
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("delete teachers");
    }

    public function restore(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("delete teachers");
    }

    public function forceDelete(User $user, Teacher $teacher): bool
    {
        return $user->hasPermissionTo("delete teachers");
    }
}

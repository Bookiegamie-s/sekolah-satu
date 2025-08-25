<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Book;

class BookPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student", "library_staff"]);
    }

    public function view(User $user, Book $book): bool
    {
        return $user->hasAnyRole(["admin", "teacher", "student", "library_staff"]);
    }

    public function create(User $user): bool
    {
        return $user->hasAnyRole(["admin", "library_staff"]);
    }

    public function update(User $user, Book $book): bool
    {
        return $user->hasAnyRole(["admin", "library_staff"]);
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->hasAnyRole(["admin", "library_staff"]);
    }

    public function borrow(User $user, Book $book): bool
    {
        return $user->hasAnyRole(["teacher", "student"]) && $book->available_copies > 0;
    }
}

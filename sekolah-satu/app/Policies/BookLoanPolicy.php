<?php

namespace App\Policies;

use App\Models\BookLoan;
use App\Models\User;

class BookLoanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo("view book loans");
    }

    public function view(User $user, BookLoan $bookLoan): bool
    {
        return $user->hasPermissionTo("view book loans") || 
               $user->id === $bookLoan->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo("create book loans");
    }

    public function update(User $user, BookLoan $bookLoan): bool
    {
        return $user->hasPermissionTo("edit book loans") &&
               $bookLoan->status !== "returned";
    }

    public function delete(User $user, BookLoan $bookLoan): bool
    {
        return $user->hasPermissionTo("delete book loans") &&
               $bookLoan->status !== "borrowed";
    }

    public function return(User $user, BookLoan $bookLoan): bool
    {
        return $user->hasPermissionTo("edit book loans") &&
               $bookLoan->status === "borrowed";
    }

    public function generateInvoice(User $user, BookLoan $bookLoan): bool
    {
        return $user->hasPermissionTo("view book loans") || 
               $user->id === $bookLoan->user_id;
    }
}

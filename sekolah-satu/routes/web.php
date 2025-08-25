<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use Illuminate\Support\Facades\Route;

// Welcome page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard with role-based content
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Teacher management (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('teachers', TeacherController::class);
        Route::resource('classes', ClassController::class);
        Route::resource('subjects', SubjectController::class);
    });

    // Student management (Admin & Teacher)
    Route::middleware(['role:admin|teacher'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::resource('schedules', ScheduleController::class);
        Route::resource('grades', GradeController::class);
    });

    // Library management (Admin & Library Staff)
    Route::middleware(['role:admin|library_staff'])->group(function () {
        Route::resource('books', BookController::class);
        Route::resource('book-loans', BookLoanController::class);
        Route::post('book-loans/{loan}/return', [BookLoanController::class, 'return'])->name('book-loans.return');
        Route::get('book-loans/{loan}/invoice', [BookLoanController::class, 'invoice'])->name('book-loans.invoice');
    });

    // Student self-access routes
    Route::middleware(['role:student'])->group(function () {
        Route::get('my-grades', [GradeController::class, 'myGrades'])->name('grades.my');
        Route::get('my-schedule', [ScheduleController::class, 'mySchedule'])->name('schedules.my');
    });

    // Teacher self-access routes  
    Route::middleware(['role:teacher'])->group(function () {
        Route::get('my-classes', [TeacherController::class, 'myClasses'])->name('teachers.my-classes');
        Route::get('my-students', [StudentController::class, 'myStudents'])->name('students.my');
    });
});

require __DIR__.'/auth.php';

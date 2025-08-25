<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/stats', [DashboardController::class, 'getStatsData'])->name('dashboard.stats');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        
        // Teachers Management
        Route::resource('teachers', TeacherController::class);
        Route::get('teachers/{teacher}/hours', [TeacherController::class, 'getTeachingHours'])
            ->name('teachers.hours');
        
        // Students Management  
        Route::resource('students', StudentController::class);
        Route::post('students/export-grades', [StudentController::class, 'exportGrades'])
            ->name('students.export-grades');
        
        // Classes Management
        Route::resource('classes', ClassController::class);
        
        // Subjects Management
        Route::resource('subjects', SubjectController::class);
        
        // Books Management
        Route::resource('books', BookController::class);
        
    });
    
    // Admin & Teacher routes
    Route::middleware(['role:admin|teacher'])->group(function () {
        
        // Book Loans Management
        Route::resource('book-loans', BookLoanController::class);
        Route::patch('book-loans/{bookLoan}/return', [BookLoanController::class, 'return'])
            ->name('book-loans.return');
        Route::get('book-loans/{bookLoan}/invoice', [BookLoanController::class, 'generateInvoice'])
            ->name('book-loans.invoice');
        Route::post('book-loans/update-overdue', [BookLoanController::class, 'updateOverdueLoans'])
            ->name('book-loans.update-overdue');
        
        // Attendance Management
        Route::resource('attendances', AttendanceController::class)->except(['destroy']);
        Route::get('attendances/students-by-class', [AttendanceController::class, 'getStudentsByClass'])
            ->name('attendances.students-by-class');
        Route::get('attendances/report', [AttendanceController::class, 'getAttendanceReport'])
            ->name('attendances.report');
        
        // Schedules Management
        Route::resource('schedules', ScheduleController::class);
        Route::get('schedules/validate-teacher', [ScheduleController::class, 'validateTeacherSchedule'])
            ->name('schedules.validate-teacher');
        
        // Grades Management
        Route::resource('grades', GradeController::class);
        Route::get('grades/export/{class}/{subject}', [GradeController::class, 'exportGrades'])
            ->name('grades.export');
        Route::post('grades/import', [GradeController::class, 'importGrades'])
            ->name('grades.import');
        
    });
    
    // All authenticated users
    Route::group(function () {
        
        // View books (read-only for students)
        Route::get('books', [BookController::class, 'index'])->name('books.index');
        Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
        
        // View own book loans
        Route::get('my-loans', [BookLoanController::class, 'myLoans'])->name('book-loans.my');
        
        // View own attendance (students)
        Route::get('my-attendance', [AttendanceController::class, 'myAttendance'])
            ->name('attendances.my');
        
        // View own grades (students)
        Route::get('my-grades', [GradeController::class, 'myGrades'])->name('grades.my');
        
        // View schedules
        Route::get('schedules', [ScheduleController::class, 'index'])->name('schedules.index');
        
    });
    
});

require __DIR__.'/auth.php';

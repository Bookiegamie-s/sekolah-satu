<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassModel;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            "total_students" => Student::where("status", "active")->count(),
            "total_teachers" => Teacher::where("is_active", true)->count(),
            "total_classes" => ClassModel::where("is_active", true)->count(),
            "total_books" => Book::where("is_active", true)->sum("total_copies"),
            "borrowed_books" => BookLoan::where("status", "borrowed")->count(),
            "overdue_books" => BookLoan::overdue()->count(),
            "total_fines" => BookLoan::where("fine_amount", ">", 0)->sum("fine_amount"),
            "recent_loans" => BookLoan::with(["user", "book"])
                                    ->orderBy("created_at", "desc")
                                    ->take(5)
                                    ->get(),
            "overdue_loans" => BookLoan::overdue()
                                     ->with(["user", "book"])
                                     ->orderBy("due_date", "asc")
                                     ->take(5)
                                     ->get()
        ];

        return view("dashboard", compact("data"));
    }

    public function getStatsData()
    {
        return response()->json([
            "students_by_class" => ClassModel::withCount("students")->get(),
            "books_by_category" => Book::selectRaw("category, COUNT(*) as total")
                                     ->groupBy("category")
                                     ->get(),
            "monthly_loans" => BookLoan::selectRaw("MONTH(loan_date) as month, COUNT(*) as total")
                                     ->whereYear("loan_date", date("Y"))
                                     ->groupBy("month")
                                     ->get()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use App\Models\Book;
use App\Models\User;
use App\Http\Requests\BookLoanRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class BookLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = BookLoan::with(["user", "book"])
                         ->when($request->search, function($q) use ($request) {
                             $q->where("invoice_number", "like", "%{$request->search}%")
                               ->orWhereHas("user", function($user) use ($request) {
                                   $user->where("name", "like", "%{$request->search}%");
                               })
                               ->orWhereHas("book", function($book) use ($request) {
                                   $book->where("title", "like", "%{$request->search}%");
                               });
                         })
                         ->when($request->status, function($q) use ($request) {
                             $q->where("status", $request->status);
                         })
                         ->when($request->overdue, function($q) use ($request) {
                             if ($request->overdue === "yes") {
                                 $q->overdue();
                             }
                         });

        $loans = $query->orderBy("created_at", "desc")->paginate(15);

        return view("book-loans.index", compact("loans"));
    }

    public function create()
    {
        $books = Book::where("is_active", true)
                    ->where("available_copies", ">", 0)
                    ->get();
        $users = User::whereHas("roles", function($q) {
            $q->whereIn("name", ["student", "teacher"]);
        })->get();

        return view("book-loans.create", compact("books", "users"));
    }

    public function store(BookLoanRequest $request)
    {
        DB::transaction(function() use ($request) {
            $book = Book::findOrFail($request->book_id);
            
            // Check if book is available
            if ($book->available_copies <= 0) {
                throw new \Exception("Buku tidak tersedia.");
            }

            // Create loan
            $loan = BookLoan::create([
                "user_id" => $request->user_id,
                "book_id" => $request->book_id,
                "loan_date" => $request->loan_date,
                "due_date" => $request->due_date,
                "status" => "borrowed",
                "notes" => $request->notes
            ]);

            // Decrease available copies
            $book->decreaseAvailableCopies();
        });

        return redirect()->route("book-loans.index")->with("success", "Peminjaman berhasil dicatat.");
    }

    public function show(BookLoan $bookLoan)
    {
        $bookLoan->load(["user", "book"]);
        
        return view("book-loans.show", compact("bookLoan"));
    }

    public function edit(BookLoan $bookLoan)
    {
        if ($bookLoan->status === "returned") {
            return back()->with("error", "Tidak dapat mengedit peminjaman yang sudah dikembalikan.");
        }

        return view("book-loans.edit", compact("bookLoan"));
    }

    public function update(BookLoanRequest $request, BookLoan $bookLoan)
    {
        $bookLoan->update($request->validated());

        return redirect()->route("book-loans.index")->with("success", "Data peminjaman berhasil diupdate.");
    }

    public function destroy(BookLoan $bookLoan)
    {
        if ($bookLoan->status === "borrowed") {
            return back()->with("error", "Tidak dapat menghapus peminjaman yang masih aktif.");
        }

        $bookLoan->delete();

        return redirect()->route("book-loans.index")->with("success", "Data peminjaman berhasil dihapus.");
    }

    public function return(BookLoan $bookLoan)
    {
        if ($bookLoan->status === "returned") {
            return back()->with("error", "Buku sudah dikembalikan.");
        }

        DB::transaction(function() use ($bookLoan) {
            // Calculate fine if overdue
            if ($bookLoan->isOverdue()) {
                $bookLoan->fine_amount = $bookLoan->calculateFine();
                $bookLoan->status = "returned";
            }

            $bookLoan->markAsReturned();
        });

        return back()->with("success", "Buku berhasil dikembalikan.");
    }

    public function generateInvoice(BookLoan $bookLoan)
    {
        $bookLoan->load(["user", "book"]);
        
        $pdf = PDF::loadView("book-loans.invoice", compact("bookLoan"));
        
        return $pdf->download("invoice-{$bookLoan->invoice_number}.pdf");
    }

    public function updateOverdueLoans()
    {
        $overdueLoans = BookLoan::where("status", "borrowed")
                              ->where("due_date", "<", now())
                              ->get();

        foreach ($overdueLoans as $loan) {
            $loan->markAsOverdue();
        }

        return response()->json([
            "message" => "Overdue loans updated",
            "count" => $overdueLoans->count()
        ]);
    }

    /**
     * Show book loans for authenticated user
     */
    public function myBookLoans()
    {
        $user = auth()->user();
        
        $loans = BookLoan::with(['book'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('book-loans.my-loans', compact('loans'));
    }
}

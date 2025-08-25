<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Http\Requests\BookRequest;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
        $this->middleware("permission:view books")->only(["index", "show"]);
        $this->middleware("permission:create books")->only(["create", "store"]);
        $this->middleware("permission:edit books")->only(["edit", "update"]);
        $this->middleware("permission:delete books")->only(["destroy"]);
    }

    public function index(Request $request)
    {
        $query = Book::query()
                    ->when($request->search, function($q) use ($request) {
                        $q->where("title", "like", "%{$request->search}%")
                          ->orWhere("author", "like", "%{$request->search}%")
                          ->orWhere("isbn", "like", "%{$request->search}%");
                    })
                    ->when($request->category, function($q) use ($request) {
                        $q->where("category", $request->category);
                    })
                    ->when($request->availability, function($q) use ($request) {
                        if ($request->availability === "available") {
                            $q->where("available_copies", ">", 0);
                        } elseif ($request->availability === "unavailable") {
                            $q->where("available_copies", "=", 0);
                        }
                    });

        $books = $query->paginate(12);
        $categories = Book::distinct()->pluck("category");

        return view("books.index", compact("books", "categories"));
    }

    public function create()
    {
        return view("books.create");
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());

        return redirect()->route("books.index")->with("success", "Buku berhasil ditambahkan.");
    }

    public function show(Book $book)
    {
        $book->load("loans.user");
        
        return view("books.show", compact("book"));
    }

    public function edit(Book $book)
    {
        return view("books.edit", compact("book"));
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return redirect()->route("books.index")->with("success", "Data buku berhasil diupdate.");
    }

    public function destroy(Book $book)
    {
        if ($book->loans()->where("status", "borrowed")->exists()) {
            return back()->with("error", "Tidak dapat menghapus buku yang sedang dipinjam.");
        }

        $book->delete();

        return redirect()->route("books.index")->with("success", "Buku berhasil dihapus.");
    }
}

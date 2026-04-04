<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Student;

class UserBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $books = Book::when($search, function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })->latest()->paginate(10);

        return view('user.books', compact('books'));
    }

    public function detail($id)
    {
        $book = Book::findOrFail($id);

        return view('user.book_detail', compact('book'));
    }

    public function myBooks()
    {
        $student = Student::where('user_id', auth()->id())->first();

        if (!$student) {
            $borrowings = collect();
        } else {
            $borrowings = Borrowing::with('book')
                ->where('student_id', $student->id)
                ->latest()
                ->get();
        }

        return view('user.mybooks', compact('borrowings'));
    }
}
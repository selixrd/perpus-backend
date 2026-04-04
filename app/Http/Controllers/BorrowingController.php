<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{

    public function borrow(Request $request, $book_id)
    {

        $book = Book::findOrFail($book_id);

        if ($request->student_id) {
            $student = Student::find($request->student_id);
        } else {
            $student = Student::where('user_id', auth()->id())->first();
        }

        if (!$student) {
            return back()->with('error', 'Student tidak ditemukan!');
        }

        $borrowCount = Borrowing::where('student_id', $student->id)
            ->whereNull('return_date')
            ->count();

        if ($borrowCount >= 3) {
            return back()->with('error', 'Maksimal meminjam 3 buku!');
        }

        if ($book->stock <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        DB::transaction(function () use ($student, $book) {

            Borrowing::create([
                'student_id' => $student->id,
                'book_id' => $book->id,
                'borrow_date' => now()
            ]);

            // kurangi stock (lebih aman)
            $book->decrement('stock');

            // update status
            if ($book->stock == 0) {
                $book->status = 'borrowed';
            } else {
                $book->status = 'available';
            }

            $book->save();

        });

        return back()->with('success', 'Buku berhasil dipinjam!');
    }


    public function returnBook($book_id)
    {

        $book = Book::findOrFail($book_id);

        $borrowing = Borrowing::where('book_id', $book->id)
            ->whereNull('return_date')
            ->latest()
            ->first();

        if (!$borrowing) {
            return back()->with('error', 'Data peminjaman tidak ditemukan!');
        }

        DB::transaction(function () use ($book, $borrowing) {

            $borrowing->return_date = now();
            $borrowing->save();

            // tambah stock (lebih aman)
            $book->increment('stock');

            $book->status = 'available';
            $book->save();

        });

        return back()->with('success', 'Buku berhasil dikembalikan!');
    }

}
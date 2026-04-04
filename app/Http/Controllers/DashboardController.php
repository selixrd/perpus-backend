<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use App\Models\Borrowing;

class DashboardController extends Controller
{
    public function index()
    {
        // jika user bukan admin → arahkan ke halaman user
        if(auth()->user()->role != 'admin'){

            $student = Student::where('user_id', auth()->id())->first();

            if(!$student){
                return redirect()->route('user.profile')
                    ->with('warning','Lengkapi profil siswa dulu!');
            }

            return redirect()->route('user.books');
        }

        // jumlah judul buku
        $books = \DB::table('books')->count();

        // jumlah siswa
        $students = Student::count();

        // jumlah buku yang sedang dipinjam
        $borrowed = Borrowing::whereNull('return_date')->count();

        // jumlah stock buku yang masih tersedia
        $available = Book::sum('stock');

        // aktivitas terbaru
        $recentActivities = Borrowing::with('student','book')
            ->latest()
            ->take(5)
            ->get();

        // buku overdue
        $overdue = Borrowing::whereNull('return_date')
            ->where('borrow_date','<', now()->subDays(7))
            ->count();

        return view('dashboard', compact(
            'books',
            'students',
            'borrowed',
            'available',
            'recentActivities',
            'overdue'
        ));
    }
}
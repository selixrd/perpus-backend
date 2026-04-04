<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\UserBookController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('books', BookController::class);
    Route::resource('students', StudentController::class);

    Route::post('/borrow/{book}', [BorrowingController::class, 'borrow'])->name('borrow.book');
    Route::post('/return/{book}', [BorrowingController::class, 'returnBook'])->name('return.book');

    Route::get('/browse-books', [UserBookController::class, 'index'])->name('user.books');
    Route::get('/book/{id}', [UserBookController::class, 'detail'])->name('user.book.detail');
    Route::get('/my-borrowed-books', [UserBookController::class, 'myBooks'])->name('user.mybooks');

    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('user.profile');
    Route::post('/user/profile', [StudentController::class, 'storeProfile'])->name('user.profile.store');
});

require __DIR__.'/auth.php';t
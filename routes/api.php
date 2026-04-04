<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Student;
use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Validation\Rule;

/*
|--------------------------------------------------------------------------
| BOOKS
|--------------------------------------------------------------------------
*/
Route::get('/books', function () {
    return response()->json(Book::all());
});

/*
|--------------------------------------------------------------------------
| BORROW (hanya student boleh pinjam)
|--------------------------------------------------------------------------
*/
Route::post('/borrow', function (Request $request) {

    $request->validate([
        'book_id' => 'required|exists:books,id',
        'user_id' => 'required|exists:users,id'
    ]);

    return DB::transaction(function () use ($request) {

        $user = User::findOrFail($request->user_id);

        if ($user->role !== 'student') {
            return response()->json([
                'message' => 'Hanya student yang boleh meminjam buku'
            ], 403);
        }

        // ambil data student dari user
        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return response()->json([
                'message' => 'Lengkapi data profil terlebih dahulu'
            ], 400);
        }

        $activeBorrow = Borrowing::where('student_id', $student->id)
    ->whereNull('return_date')
    ->count();

if ($activeBorrow >= 3) {
    return response()->json([
        'message' => 'Maksimal 3 buku sedang dipinjam'
    ], 400);
}

        // ambil buku + lock biar aman
        $book = Book::where('id', $request->book_id)
            ->lockForUpdate()
            ->firstOrFail();

        if ($book->stock <= 0) {
            return response()->json([
                'message' => 'Stok buku habis'
            ], 400);
        }

        // kurangi stok
        $book->decrement('stock');

        // simpan ke borrowings
        Borrowing::create([
            'student_id' => $student->id,
            'book_id' => $request->book_id,
            'borrow_date' => now(),
        ]);

        return response()->json([
            'message' => 'Buku berhasil dipinjam'
        ]);
    });
});

/*
|--------------------------------------------------------------------------
| MY BOOKS
|--------------------------------------------------------------------------
*/
Route::get('/my-books', function (Request $request) {

    $request->validate([
        'user_id' => 'required|exists:users,id'
    ]);

    $student = Student::where('user_id', $request->user_id)->first();

    if (!$student) {
        return response()->json([]);
    }

    $borrows = Borrowing::with('book')
        ->where('student_id', $student->id)
        ->latest()
        ->get();

    return response()->json($borrows);
});

/*
|--------------------------------------------------------------------------
| GET PROFILE
|--------------------------------------------------------------------------
*/
Route::get('/profile/{id}', function ($id) {

    $user = User::findOrFail($id);
    $student = Student::where('user_id', $id)->first();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'role' => $user->role,
        'photo' => $user->photo
            ? asset('storage/' . $user->photo)
            : null,

        'student_name' => $student->name ?? '',
        'nis' => $student->nis ?? '',
        'class' => $student->class ?? '',
        'major' => $student->major ?? '',
        'address' => $student->address ?? '',
    ]);
});

/*
|--------------------------------------------------------------------------
| UPDATE PROFILE STUDENT
|--------------------------------------------------------------------------
*/
Route::post('/profile/student/update', function (Request $request) {

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'name' => 'required',
        'nis' => 'required',
        'class' => 'required',
        'major' => 'required',
        'address' => 'required',
    ]);

    Student::updateOrCreate(
        ['user_id' => $request->user_id],
        [
            'name' => $request->name,
            'nis' => $request->nis,
            'class' => $request->class,
            'major' => $request->major,
            'address' => $request->address,
        ]
    );

    return response()->json([
        'message' => 'Profile berhasil diupdate'
    ]);
});

Route::post('/profile/update-account', function (Request $request) {

    $request->validate([
        'user_id' => ['required', 'exists:users,id'],
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'email',
            Rule::unique('users', 'email')->ignore($request->user_id),
        ],
    ]);

    $user = User::findOrFail($request->user_id);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
    ]);

    return response()->json([
        'message' => 'Akun berhasil diupdate',
        'user' => $user,
    ]);
});

/*
|--------------------------------------------------------------------------
| UPDATE PASSWORD
|--------------------------------------------------------------------------
*/
Route::post('/profile/password', function (Request $request) {

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'password' => 'required|min:6',
    ]);

    $user = User::findOrFail($request->user_id);

    $user->update([
        'password' => Hash::make($request->password)
    ]);

    return response()->json([
        'message' => 'Password berhasil diubah'
    ]);
});

/*
|--------------------------------------------------------------------------
| UPDATE PHOTO
|--------------------------------------------------------------------------
*/
Route::post('/profile/photo', function (Request $request) {

    $request->validate([
        'user_id' => 'required|exists:users,id',
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048'
    ]);

    $user = User::findOrFail($request->user_id);

    $path = $request->file('photo')->store('profile', 'public');

    $user->update([
        'photo' => $path
    ]);

    return response()->json([
        'message' => 'Foto berhasil diupload',
        'photo' => asset('storage/' . $path)
    ]);
});

/*
|--------------------------------------------------------------------------
| REGISTER
|--------------------------------------------------------------------------
*/
Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'student',
    ]);

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Register berhasil',
        'token' => $token,
        'user' => $user,
    ]);
});

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Email atau password salah'
        ], 401);
    }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'message' => 'Login berhasil',
        'token' => $token,
        'user' => $user,
    ]);
});
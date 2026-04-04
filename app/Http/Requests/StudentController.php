<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::latest()->paginate(10);
        return view('students.index', compact('students'));
    }

    public function create(): View
    {
        return view('students.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required',
            'nis' => 'required|unique:students',
            'class' => 'required',
            'major' => 'nullable',
            'address' => 'nullable',
        ]);

        Student::create($data);

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan!');
    }

    public function show(string $id): View
    {
        $student = Student::with('borrowings.book')->findOrFail($id);

        $totalBorrow = $student->borrowings->count();
        $currentlyBorrowed = $student->borrowings->whereNull('return_date')->count();
        $returnedBooks = $student->borrowings->whereNotNull('return_date')->count();

        return view('students.show', compact(
            'student',
            'totalBorrow',
            'currentlyBorrowed',
            'returnedBooks'
        ));
    }

    public function edit(string $id): View
    {
        $student = Student::findOrFail($id);
        return view('students.edit', compact('student'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $student = Student::findOrFail($id);

        $data = $request->validate([
            'name' => 'required',
            'nis' => 'required|unique:students,nis,' . $student->id,
            'class' => 'required',
            'major' => 'nullable',
            'address' => 'nullable',
        ]);

        $student->update($data);

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diupdate!');
    }

    public function destroy(string $id): RedirectResponse
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus!');
    }

    // ===============================
    // USER PROFILE (My Profile)
    // ===============================

  public function storeProfile(Request $request)
{
    $request->validate([
        'name' => 'required',
        'nis' => 'required',
        'class' => 'required',
        'major' => 'required',
        'address' => 'nullable',
    ]);

    $student = Student::where('user_id', auth()->id())->first();

    if ($student) {

        $student->update([
            'name' => $request->name,
            'nis' => $request->nis,
            'class' => $request->class,
            'major' => $request->major,
            'address' => $request->address,
        ]);

    } else {

        Student::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'nis' => $request->nis,
            'class' => $request->class,
            'major' => $request->major,
            'address' => $request->address,
        ]);

    }

    return redirect()->route('profile.edit')
    ->with('success','Profile berhasil disimpan!');
}
}
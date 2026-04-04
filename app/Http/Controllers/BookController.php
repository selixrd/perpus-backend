<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{

    public function index(Request $request): View
    {
        $search = $request->search;

        $books = Book::when($search, function ($query) use ($search) {
            $query->where('title','like','%'.$search.'%');
        })->latest()->paginate(20);

        $students = Student::all();

        return view('books.index', compact('books','students'));
    }


    public function create(): View
    {
        return view('books.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'cover'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'title'       => 'required|min:3',
            'author'      => 'required|min:3',
            'year'        => 'nullable|digits:4',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable',
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        // default status
        $data['status'] = 'available';

        Book::create($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book berhasil ditambahkan!');
    }


    public function show(string $id): View
    {
        $book = Book::with('borrowings.student')->findOrFail($id);

        return view('books.show', compact('book'));
    }


    public function edit(string $id): View
    {
        $book = Book::findOrFail($id);

        return view('books.edit', compact('book'));
    }


    public function update(Request $request, string $id): RedirectResponse
    {

        $book = Book::findOrFail($id);

        $data = $request->validate([
            'cover'       => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'title'       => 'required|min:3',
            'author'      => 'required|min:3',
            'year'        => 'nullable|digits:4',
            'stock'       => 'required|integer|min:0',
            'description' => 'nullable',
        ]);


        if ($request->hasFile('cover')) {

            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()
            ->route('books.index')
            ->with('success', 'Book berhasil diupdate!');
    }


    public function destroy(string $id): RedirectResponse
    {

        $book = Book::findOrFail($id);

        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Book berhasil dihapus!');
    }

}
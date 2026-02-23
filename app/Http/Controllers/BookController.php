<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // require login (Breeze)
    }

    public function index()
    {
        $books = Book::with('authors')->latest()->paginate(15);
        return view('books.index', compact('books'));
    }

    public function create()
    {
        $authors = Author::orderBy('name')->get();
        return view('books.create', compact('authors'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100|unique:books,isbn',
            'publisher' => 'nullable|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'year_published' => 'nullable|digits:4|integer',
            'description' => 'nullable|string',
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ]);

        DB::transaction(function () use ($data) {
            $book = Book::create([
                'title' => $data['title'],
                'isbn' => $data['isbn'] ?? null,
                'publisher' => $data['publisher'] ?? null,
                'total_copies' => $data['total_copies'],
                // at creation available == total
                'available_copies' => $data['total_copies'],
                'year_published' => $data['year_published'] ?? null,
                'description' => $data['description'] ?? null,
            ]);

            if (!empty($data['authors'])) {
                $book->authors()->sync($data['authors']);
            }
        });

        return redirect()->route('books.index')->with('success', 'Book created.');
    }

    public function show(Book $book)
    {
        $book->load('authors');
        return view('books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $authors = Author::orderBy('name')->get();
        $book->load('authors');
        return view('books.edit', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => ['nullable','string','max:100', Rule::unique('books','isbn')->ignore($book->id)],
            'publisher' => 'nullable|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'year_published' => 'nullable|digits:4|integer',
            'description' => 'nullable|string',
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ]);

        DB::transaction(function () use ($data, $book) {
            // When changing total_copies, ensure we don't go below borrowed copies.
            $oldTotal = $book->total_copies;
            $oldAvailable = $book->available_copies;
            $lentOut = $oldTotal - $oldAvailable; // copies currently borrowed

            $newTotal = (int)$data['total_copies'];

            if ($newTotal < $lentOut) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'total_copies' => "Total copies cannot be less than currently lent out copies ({$lentOut})."
                ]);
            }

            // compute new available = newTotal - lentOut
            $newAvailable = $newTotal - $lentOut;

            $book->update([
                'title' => $data['title'],
                'isbn' => $data['isbn'] ?? null,
                'publisher' => $data['publisher'] ?? null,
                'total_copies' => $newTotal,
                'available_copies' => $newAvailable,
                'year_published' => $data['year_published'] ?? null,
                'description' => $data['description'] ?? null,
            ]);

            $book->authors()->sync($data['authors'] ?? []);
        });

        return redirect()->route('books.show', $book)->with('success', 'Book updated.');
    }

    public function destroy(Book $book)
    {
        // prevent delete if copies are currently lent out
        $lentOut = $book->total_copies - $book->available_copies;
        if ($lentOut > 0) {
            return redirect()->back()->withErrors(['error' => 'Cannot delete book while copies are lent out.']);
        }

        $book->authors()->detach();
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}
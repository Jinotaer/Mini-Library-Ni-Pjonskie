<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // require login (Breeze)
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));

        $books = Book::query()
            ->with('authors')
            ->when($search !== '', function ($query) use ($search): void {
                $keyword = '%'.$search.'%';
                $query->where(function ($bookQuery) use ($keyword): void {
                    $bookQuery
                        ->where('title', 'like', $keyword)
                        ->orWhere('isbn', 'like', $keyword)
                        ->orWhere('authors', 'like', $keyword)
                        ->orWhere('year_published', 'like', $keyword)
                        ->orWhereHas('authors', function ($authorQuery) use ($keyword): void {
                            $authorQuery->where('name', 'like', $keyword);
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();
        $authors = Author::orderBy('name')->get();

        return view('books.index', compact('books', 'authors'));
    }

    public function create(): View
    {
        $authors = Author::orderBy('name')->get();

        return view('books.index', compact('authors'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:100|unique:books,isbn',
            'author' => 'nullable|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'year_published' => 'nullable|digits:4|integer',
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ]);

        DB::transaction(function () use ($data) {
            $book = Book::create([
                'title' => $data['title'],
                'isbn' => $data['isbn'] ?? null,
                'author' => $data['author   '] ?? null,
                'total_copies' => $data['total_copies'],
                // at creation available == total
                'available_copies' => $data['total_copies'],
                'year_published' => $data['year_published'] ?? null,
            ]);

            if (! empty($data['authors'])) {
                $book->authors()->sync($data['authors']);
            }
        });

        return redirect()->route('books.index')->with('success', 'Book created.');
    }

    public function show(Book $book): View
    {
        $book->load('authors');

        return view('books.index', compact('book'));
    }

    public function edit(Book $book): View
    {
        $authors = Author::orderBy('name')->get();
        $book->load('authors');

        return view('books.index', compact('book', 'authors'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'isbn' => ['nullable', 'string', 'max:100', Rule::unique('books', 'isbn')->ignore($book->id)],
            'author' => 'nullable|string|max:255',
            'total_copies' => 'required|integer|min:1',
            'year_published' => 'nullable|digits:4|integer',
            'authors' => 'nullable|array',
            'authors.*' => 'exists:authors,id',
        ]);

        DB::transaction(function () use ($data, $book) {
            // When changing total_copies, ensure we don't go below borrowed copies.
            $oldTotal = $book->total_copies;
            $oldAvailable = $book->available_copies;
            $lentOut = $oldTotal - $oldAvailable; // copies currently borrowed

            $newTotal = (int) $data['total_copies'];

            if ($newTotal < $lentOut) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'total_copies' => "Total copies cannot be less than currently lent out copies ({$lentOut}).",
                ]);
            }

            // compute new available = newTotal - lentOut
            $newAvailable = $newTotal - $lentOut;

            $book->update([
                'title' => $data['title'],
                'isbn' => $data['isbn'] ?? null,
                'author' => $data['author'] ?? null,
                'total_copies' => $newTotal,
                'available_copies' => $newAvailable,
                'year_published' => $data['year_published'] ?? null,

            ]);

            $book->authors()->sync($data['authors'] ?? []);
        });

        return redirect()->route('books.index', $book)->with('success', 'Book updated.');
    }

    public function destroy(Book $book): RedirectResponse
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

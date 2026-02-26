<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // require login
    }

    public function index()
    {
        $authors = Author::withCount('books')->orderBy('name')->paginate(20);

        return view('authors.index', compact('authors'));
    }

    public function create()
    {
        return view('authors.index'); // show index with create form
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        Author::create($data);

        return redirect()->route('authors.index')->with('success', 'Author created.');
    }

    public function show(Author $author)
    {
        $author->load('books');

        return view('authors.index', compact('author'));
    }

    public function edit(Author $author)
    {
        return view('authors.index', compact('author'));
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $author->update($data);

        return redirect()->route('authors.index')->with('success', 'Author updated.');
    }

    public function destroy(Author $author)
    {
        // detach books, then delete
        $author->books()->detach();
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted.');
    }
}

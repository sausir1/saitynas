<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json($authors, 200);
    }

    public function show($slug)
    {
        $author = Author::where('id', $slug)->firstOrFail();
        return response()->json($author, 200);
    }

    public function showBooks($author)
    {
        $books = Book::where('author_id', $author)->get();   //where('id', $author)->firstOrFail()->books;
        return response()->json($books, 200);
    }

    public function store(AuthorRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $author = Author::create($validated);
        return response()->json($author, 201);
    }

    public function update(Author $author, AuthorRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $author->updateOrFail($validated);
        return response()->json($author, 200);
    }

    public function destroy(Author $author)
    {
        $this->authorize('admin');
        $temp = $author;
        $author->deleteOrFail();
        return response()->json(["author" => $temp, "status" => "deleted successfully"], 202);
    }
}

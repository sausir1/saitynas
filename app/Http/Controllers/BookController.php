<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index($id = null)
    {

        $books = Book::writtenBy($id)->with("ratings")->get();
        return response()->json($books, 200);
    }

    public function show($author, $slug)
    {
        $book = Book::where('slug', $slug)->writtenBy($author)->firstOrFail();
        return response()->json($book, 200);
    }

    public function store(BookRequest $request)
    {
        $this->authorize('admin');
        $validated = $request->validated();
        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    public function update($author, $book, BookRequest $request)
    {
        $this->authorize('admin');
        $book = Book::where('slug', $book)->where('author_id', $author)->firstOrFail();
        $validated = $request->validated();
        $book->updateOrFail($validated);
        return response()->json($book, 200);
    }

    public function destroy($author, $book)
    {
        $this->authorize('admin');
        $book = Book::where('slug', $book)->where('author_id', $author)->firstOrFail();
        $book->delete();
        return response()->json($book, 202);
    }
}

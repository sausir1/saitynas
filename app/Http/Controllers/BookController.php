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
        // $averages = $books->map(function ($book) {
        //     return $book->ratings->avg('rating');
        // }); RESOURCE PANAUDOTI SITA
        return response()->json($books, 200);
    }

    public function show($author, $slug)
    {
        // ->with(['author', 'category', 'comments'])->
        $book = Book::where('slug', $slug)->where('author_id', $author)->firstOrFail();
        return response()->json($book, 200);
    }

    public function store(BookRequest $request)
    {
        $validated = $request->validated();
        $book = Book::create($validated);
        return response()->json($book, 201);
    }

    public function update($author, $book, BookRequest $request)
    {
        $book = Book::where('slug', $book)->where('author_id', $author)->firstOrFail();
        $validated = $request->validated();
        $book->updateOrFail($validated);
        return response()->json($book, 200);
    }

    public function destroy($author, $book)
    {
        $book = Book::where('slug', $book)->where('author_id', $author)->firstOrFail();
        $book->delete();
        return response()->json($book, 202);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with(["ratings"])->get();
        // $averages = $books->map(function ($book) {
        //     return $book->ratings->avg('rating');
        // }); RESOURCE PANAUDOTI SITA
        return response()->json(compact('books', 'averages'), 200);
    }

    public function show($slug)
    {
        // $book = new BookResource(->first());
        $book = Book::where('slug', $slug)->with(['author', 'category', 'comments'])->firstOrFail();
        return response()->json(compact('book'), 200);
    }

    public function create(BookRequest $request)
    {
        $validated = $request->validated();
        $book = Book::create($validated);
        return response()->json(compact('book'), 201);
    }

    public function edit(Book $book, BookRequest $request)
    {
        $validated = $request->validated();
        $book->updateOrFail($validated);
        return response()->json(compact('book'), 200);
    }

    public function delete(Book $book)
    {
        $book->delete();
        return response()->json(compact('book'), 200);
    }
}

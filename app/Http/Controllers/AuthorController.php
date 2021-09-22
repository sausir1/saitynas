<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return response()->json(compact('authors'), 200);
    }

    public function show($slug)
    {
        $author = Author::where('id', $slug)->with('books')->firstOrFail();
        return response()->json(compact('author'), 200);
    }

    public function create(AuthorRequest $request)
    {
        $validated = $request->validated();
        $author = Author::create($validated);
        return response()->json(compact('author'), 201);
    }

    public function edit(Author $author, AuthorRequest $request)
    {
        $validated = $request->validated();
        $author->updateOrFail($validated);
        return response()->json(compact('author'), 200);
    }

    public function delete(Author $author)
    {
        $author->delete();
        return response()->json(compact('author'), 200);
    }
}

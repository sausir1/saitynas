<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Resources\CommentsCollection;
use App\Http\Resources\CommentsResource;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $result = match (request()->route()->getName()) {
            'authors.books.comments.index' => $this->indexOnBook(request()->route('book'))
        };
        $collection = CommentsResource::collection($result);
        return response()->json($collection, 200);
    }

    private function indexOnBook($book)
    {
        $comments = Book::where('slug', $book)->with('comments')->firstOrFail()->comments;
        return $comments;
    }

    public function show(...$params)
    {
        $result = match (request()->route()->getName()) {
            'authors.books.comments.show' => $this->showOnBook($params[2], $params[1], $params[0])
        };
        $comment = new CommentsResource($result);
        return response()->json($comment);
    }

    private function showOnBook($comment, $book, $author)
    {
        $comments = Book::where('slug', $book)->where('author_id', $author)->with('comments')->firstOrFail()->comments;
        foreach ($comments as $key => $value) {
            if ($value->pivot->id == $comment) {
                return $value;
            }
        }
        throw new ModelNotFoundException('No query results for [App\\Models\\Comment] ' . $comment);
    }

    public function destroy(...$params)
    {
        [$result, $commentId] = match (request()->route()->getName()) {
            'authors.books.comments.destroy' => [$this->showOnBook($params[2], $params[1], $params[0]), $params[2]]
        };
        $comment = new CommentsResource($result);
        Comment::destroy($commentId);
        return response()->json($comment, 202);
    }

    public function store(CommentRequest $request)
    {
        $validated = $request->validated();
        $comment = Comment::create($validated);

        return response()->json($comment, 201);
    }

    public function update(CommentRequest $request, ...$params)
    {
        [$result, $commentId] = match (request()->route()->getName()) {
            'authors.books.comments.update' => [$this->showOnBook($params[2], $params[1], $params[0]), $params[2]] //Grazinama knyga arba error'as jeigu ne tam priklauso ta knyga
        };
        $validated = $request->validated();
        $toUpdate = Comment::findOrFail($commentId);
        $toUpdate->updateOrFail($validated);
        $result = match (request()->route()->getName()) {
            'authors.books.comments.update' => $this->showOnBook($params[2], $params[1], $params[0]) //Grazinama knyga arba error'as jeigu ne tam priklauso ta knyga
        };
        $comment = new CommentsResource($result);
        return response()->json($comment, 200);
    }
}

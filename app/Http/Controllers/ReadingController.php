<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReadingsRequest;
use App\Http\Requests\ReadingsUpdateRequest;
use App\Http\Resources\ReadingsResource;
use App\Models\Book;
use App\Models\Reading;
use Illuminate\Http\Request;

class ReadingController extends Controller
{
    public function index()
    {
        $readings = request()->user()->readings;
        $results = ReadingsResource::collection($readings);
        return response()->json($results, 200);
    }

    public function show($bookId)
    {
        $reading = request()->user()->readings()->wherePivot('book_id', $bookId)->firstOrFail();
        return response()->json(new ReadingsResource($reading));
    }

    public function store(ReadingsRequest $request)
    {
        $user = $request->user();
        $validated = $request->validated();
        $reading = new Reading($validated);
        $isBook = $user->readings()->wherePivot('book_id', $reading->book_id)->first();
        if (!$isBook) {
            $request->user()->readings()->attach([$reading->book_id], [
                'current_page' => $reading->current_page,
                'total_pages' => $reading->total_pages,
                'owns' => $reading->owns,
                'started_at' => $reading->started_at,
                'finished_at' => $reading->finished_at
            ], true);
            $reading = $user->readings()->wherePivot('book_id', $reading->book_id)->firstOrFail();
            return response()->json(new ReadingsResource($reading), 201);
        }
        return response()->json(["message" => "The Book you're trying to add to readings already exists!"], 400);
    }

    public function update($bookId, ReadingsUpdateRequest $request)
    {
        $validated = $request->validated();
        $request->user()->readings()->updateExistingPivot($bookId, $validated);
        $reading = $request->user()->readings()->wherePivot('book_id', $bookId)->firstOrFail();
        return response()->json(new ReadingsResource($reading), 200);
    }

    public function destroy($bookId)
    {
        $result = request()->user()->readings()->wherePivot('book_id', $bookId)->firstOrFail();
        request()->user()->readings()->detach($result);
        return response()->json(new ReadingsResource($result), 202);
    }
}

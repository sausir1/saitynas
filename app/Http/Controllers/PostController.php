<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{

    //Traitas has followers
    public function index()
    {
        //su reitingu reiktu
        return response()->json(["posts" => Post::all()], 200);
    }
    public function show($slug)
    {
        // FIXME: like'ai, komentarai, autorius

        $post = Post::where('slug', $slug)->with(['comments', 'author'])->firstOrFail();
        return response()->json(compact('post'), 200);
    }

    public function create(PostRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create($validated);
        return response()->json(compact('post'), 201);
    }

    public function edit(Post $post, PostRequest $request)
    {
        $validated = $request->validated();
        $post->updateOrFail($validated);
        return response()->json(compact('post'), 200);
    }

    public function delete(Post $post)
    {
        $post->delete();
        return response()->json(compact('post'), 200);
    }
}

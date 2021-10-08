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
        return response()->json(["posts" => Post::all()], 200);
    }
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return response()->json('post', 200);
    }

    public function store(PostRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create($validated);
        return response()->json($post, 201);
    }

    public function update($slug, PostRequest $request)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $validated = $request->validated();
        $post->updateOrFail($validated);
        return response()->json($post, 200);
    }

    public function destroy($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        $post->deleteOrFail();
        return response()->json($post, 202);
    }
}

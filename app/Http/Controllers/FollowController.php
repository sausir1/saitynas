<?php

namespace App\Http\Controllers;

use App\Http\Requests\FollowRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function getMyFollows()
    {
        $user = User::with(['followedBooks', 'followedPosts', 'followedUsers'])->where('id', request()->user()->id)->firstOrFail();
        return response()->json(["books" => $user->followedBooks, "posts" => $user->followedPosts, "users" => $user->followedUsers]);
    }

    private function followPost($post)
    {
        return Post::where('slug', $post)->firstOrFail()->follow();
    }

    private function followUser($user)
    {
        return User::where('username', $user)->firstOrFail()->follow();
    }
    private function followAuthor($author)
    {
        return Author::where('slug', $author)->firstOrFail()->follow();
    }
    private function followBook($book)
    {
        return Book::where('slug', $book)->firstOrFail()->follow();
    }

    public function follow(FollowRequest $request)
    {
        $validated = $request->validated();
        $result = null;
        switch ($validated['followable']) {
            case 'book':
                $result = $this->followBook($validated['identifier']);
                break;
            case 'post':
                $result = $this->followPost($validated['identifier']);
                break;
            case 'author':
                $result = $this->followAuthor($validated['identifier']);
                break;
            case 'user':
                $result = $this->followUser($validated['identifier']);
                break;
            default:
                return response()->json(["error" => "Unrecognised followable type! Possible followables: user, author, post, book"], 422);
                break;
        }
        return response()->json($result, 201);
    }
}

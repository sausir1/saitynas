<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Goal;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin', function (User $user) {
            return $user->is_admin;
        });

        Gate::define('manage-comments', function (User $user, Comment $comment) {
            return $user->id == $comment->user_id || $user->is_admin;
        });

        Gate::define('manage-posts', function (User $user, Post $post) {
            return $user->id == $post->user_id || $user->is_admin;
        });

        Gate::define('manage-goals', function (User $user, Goal $goal) {
            return $user->id == $goal->user_id;
        });

        Relation::morphMap([
            "Like" => "App\Models\Like",
            "User" => "App\Models\User",
            "Book" => "App\Models\Book",
            "Comment" => "App\Models\Comment",
            "Post" => "App\Models\Post",
            "Author" => "App\Models\Author"
        ]);
    }
}

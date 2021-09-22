<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
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

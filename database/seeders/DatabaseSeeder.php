<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Comment;
use App\Models\Goal;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        Book::factory(10)->create();
        Goal::factory(5)->create();
        Comment::factory(15)->create();
    }
}

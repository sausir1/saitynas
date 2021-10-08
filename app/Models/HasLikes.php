<?php

namespace App\Models;

use App\Models\User;

trait HasLikes
{

    public function like($user)
    {
        $user = $user ?: auth()->user();
        return $this->likes()->attach($user);
    }

    public function likes()
    {
        return $this->morphToMany(User::class, 'likeable', 'likes')->withTimestamps();
    }
}

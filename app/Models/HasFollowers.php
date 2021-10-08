<?php

namespace App\Models;

trait HasFollowers
{
    public function follow($user = null)
    {
        $user = $user ?: auth()->user();
        $result = $this->followers()->toggle($user);
        if (sizeof($result['attached']) > 0) {
            $result = "started following";
        } else {
            $result = "unfollowed";
        }
        return [$this->table => $this, "status" => $result];
    }

    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows')->withTimestamps();
    }
}

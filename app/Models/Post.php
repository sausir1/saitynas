<?php

namespace App\Models;

use App\Models\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasLikes;

    protected $fillable = [
        "title",
        "body",
        "slug",
        "user_id"
    ];

    public function comments()
    {
        return $this->morphToMany(User::class, 'commentable', 'comments');
    }

    public function author()
    {
        return $this->hasOne(User::class, 'id');
    }
}

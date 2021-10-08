<?php

namespace App\Models;

use App\Models\HasFollowers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, HasFollowers;

    public function getRouteKeyName()
    {
        return 'slug';
    }

    protected $fillable = [
        "title",
        "price",
        "slug",
        "pages",
        "author_id",
        "about",
        "category_id"
    ];

    public function scopeWrittenBy($query, $author)
    {
        $query->when(
            $author ?? false,
            fn ($query, $author) =>
            $query->where('author_id', $author)
        );
    }


    public function comments()
    {
        return $this->morphToMany(User::class, 'commentable', 'comments')->withPivot(['comment', 'id'])->withTimestamps();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

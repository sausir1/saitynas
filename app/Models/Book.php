<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "price",
        "slug",
        "pages",
        "author_id",
        "about",
        "category_id"
    ];


    public function comments()
    {
        return $this->morphToMany(User::class, 'commentable', 'comments')->withPivot('comment')->withTimestamps();
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

    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows');
    }
}

<?php

namespace App\Models;

use App\Models\HasFollowers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, HasFollowers;

    protected $fillable = [
        "name",
        "surname",
        "age",
        "nationality",
        "website",
        "about"
    ];

    public $timestamps = false;

    public function scopeAuthorBooks($query, $authorId)
    {
        $query->when(
            $authorId ?? false,
            fn ($query, $id) =>
            $query->where('id', $id)
        );
    }

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

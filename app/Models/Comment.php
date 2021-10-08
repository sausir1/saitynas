<?php

namespace App\Models;

use App\Models\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, HasLikes;

    protected $fillable = [
        'comment',
        'commentable_type',
        'commentable_id',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d'
    ];

    public function scopeOnBook($query, $book)
    {
        $query->when(
            $book ?? false,
            fn ($query, $book) =>
            $query
                ->where('commentable_type', 'Book')
                ->where('commentable_id', $book)
        );
    }

    public function commentable()
    {
        return $this->morphTo();
    }
}

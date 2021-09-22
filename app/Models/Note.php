<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function onBook()
    {
        return $this->hasManyThrough(Book::class, Reading::class);
    }
}

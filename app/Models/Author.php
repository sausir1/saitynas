<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "surname",
        "age",
        "nationality",
        "website",
        "about"
    ];

    public $timestamps = false;

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}

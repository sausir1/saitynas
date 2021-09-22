<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'goal',
        'progress',
        'until',
        'user_id'
    ];
    protected $attributes = [
        'progress' => 0,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

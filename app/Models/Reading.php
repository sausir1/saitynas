<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Reading extends Pivot
{
    // const CREATED_AT = 'started_at';
    public $table = 'readings';

    protected $casts = [
        'created_at' => 'date: Y-m-d H:i:s',
        'updated_at' => 'date: Y-m-d H:i:s'
    ];

    protected $attributes = [
        'owns' => false
    ];

    public function notes()
    {
        return $this->hasMany(Note::class, 'reading_id', 'book_id');
    }

    public function scopeReadingNotes($query, $userId, $reading)
    {
        $query
            ->where('user_id', $userId)
            ->where('book_id', $reading)
            ->with('notes');
    }
}

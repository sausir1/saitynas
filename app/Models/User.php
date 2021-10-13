<?php

namespace App\Models;

use App\Models\HasFollowers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasFollowers;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'experience' => 0,
        'is_admin' => false
    ];

    protected $fillable = [
        'name',
        'email',
        'username',
        'password'
    ];

    public function whereReadings($bookId)
    {
        return $this->readings()->wherePivot('book_id', $bookId);
    }

    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withPivot('earned_at');
    }

    public function goals()
    {
        return $this->hasMany(Goal::class);
    }

    public function rated()
    {
        return $this->belongsToMany(Book::class, 'ratings')->withPivot('rating');
    }

    public function readings()
    {
        return $this->belongsToMany(Book::class, 'readings')->withPivot(['current_page', 'total_pages', 'started_at', 'finished_at', 'owns'])->withTimestamps();
    }

    public function ownedBooks()
    {
        return $this->belongsToMany(Book::class, 'readings')->wherePivot('owns', '!=', 0)->withPivot(['current_page', 'total_pages', 'started_at', 'finished_at', 'owns']);
    }

    public function followedUsers()
    {
        return $this->morphedByMany(User::class, 'followable', 'follows')->withTimestamps();
    }

    public function followedAuthors()
    {
        return $this->morphedByMany(Author::class, 'followable', 'follows')->withTimestamps();
    }

    public function followedBooks()
    {
        return $this->morphedByMany(Book::class, 'followable', 'follows')->withTimestamps();
    }

    public function followedPosts()
    {
        return $this->morphedByMany(Post::class, 'followable', 'follows')->withTimestamps();
    }

    public function postComments()
    {
        return $this->morphedByMany(Post::class, 'commentable', 'comments')->withTimestamps()->withPivot(['comment', 'id']);
    }

    public function bookComments()
    {
        return $this->morphedByMany(Book::class, 'commentable', 'comments')->withTimestamps()->withPivot(['comment', 'id']);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'experience' => 0,
    ];

    protected $fillable = [
        'name',
        'email',
        'username',
        'password'
    ];

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
        return $this->belongsToMany(Book::class, 'readings')->withPivot(['current_page', 'total_pages', 'started_at', 'finished_at', 'owns']);
    }

    public function ownedBooks()
    {
        return $this->belongsToMany(Book::class, 'readings')->wherePivot('owns', '!=', 0)->withPivot(['current_page', 'total_pages', 'started_at', 'finished_at', 'owns']);
    }

    public function follow($followable)
    {
        return $this->followedUsers()->toggle($followable);
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

    public function followers()
    {
        return $this->morphToMany(User::class, 'followable', 'follows')->withTimestamps();
    }

    public function postComments()
    {
        return $this->morphedByMany(Post::class, 'commentable', 'comments')->withTimestamps()->withPivot('comment')->withPivot('id');
    }

    public function bookComments()
    {
        return $this->morphedByMany(Book::class, 'commentable', 'comments')->withTimestamps()->withPivot('comment')->withPivot('id');
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

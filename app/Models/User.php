<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable; // ← PENTING! Ini harus ada
    use \Illuminate\Database\Eloquent\Factories\HasFactory; // Untuk factory
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'bio',
        'profile_picture',
        'email',
        'password',
    ];
    
    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the posts for the user.
     */
    public function posts() {
        return $this->hasMany(Post::class);
    }
    
    /**
     * User yang mengikuti saya
     */
    public function followers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    
    public function following(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    /**
     * Cek apakah saya mengikuti user tertentu
     */
    public function isFollowing(User $user): bool
    {
        return $this->following()->where('user_id', $user->id)->exists();
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    
    public function followersCount(): int
{
    return $this->followers()->count();
}

public function followingCount(): int
{
    return $this->following()->count();
}



    
}
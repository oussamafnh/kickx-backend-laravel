<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

// class User extends Model

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as AuthenticatableUser;

class User extends AuthenticatableUser implements Authenticatable
{
    use HasApiTokens;
    protected $fillable = [
        'username',
        'email',
        'password',
        'profile_picture',
        'is_admin',
    ];

    protected $casts = [
        'is_admin' => 'boolean',
    ];
    public function reviews()
    {
        return $this->hasMany(Review::class, 'user_id', 'id');
    }

    public function likedSneakers()
    {
        return $this->belongsToMany(Sneaker::class, 'liked_sneakers', 'user_id', 'sneaker_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LikedSneaker extends Model
{
    protected $table = 'liked_sneakers';

    protected $fillable = [
        'user_id',
        'sneaker_id',
    ];

}

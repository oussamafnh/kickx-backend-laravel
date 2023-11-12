<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'sneaker_id',
        'user_id',
        'comment',
        'date',
    ];

    public function sneaker()
    {
        return $this->belongsTo(Sneaker::class, 'sneaker_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

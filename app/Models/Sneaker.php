<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sneaker extends Model
{
    protected $fillable = [
        'sneaker_name',
        'price',
        'description',
        'colorway',
        'release_year',
        'brand',
        'gender',
        'image_link',
    ];

    public function likes()
    {
        return $this->hasMany(LikedSneaker::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}

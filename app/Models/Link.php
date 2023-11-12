<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = ['sneaker_id', 'link', 'icon'];

    public function sneaker()
    {
        return $this->belongsTo(Sneaker::class);
    }
}

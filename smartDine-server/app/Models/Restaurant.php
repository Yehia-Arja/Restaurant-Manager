<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    /** @use HasFactory<\Database\Factories\RestaurantFactory> */
    use HasFactory;

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
    public function locations()
    {
        return $this->hasMany(RestaurantLocation::class, 'restaurant_id', 'id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }
}

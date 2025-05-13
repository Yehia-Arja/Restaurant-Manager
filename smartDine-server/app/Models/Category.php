<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
}
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;
use App\Models\RestaurantLocation;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'restaurant_id',
        'name',
        'description',
    ];

    /**
     * The branches (restaurant locations) this category applies to.
     */
    public function locations()
    {
        return $this->morphToMany(
            RestaurantLocation::class,
            'locationable',
            'locationables',
            'locationable_id',
            'restaurant_location_id'
        );
    }
}
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d

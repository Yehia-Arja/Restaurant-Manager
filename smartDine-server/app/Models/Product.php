<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * Note: we let the service layer supply these exact keys
     * (validated via FormRequest), so it’s safe to expose them here.
     */
    protected $fillable = [
        'restaurant_id',
        'category_id',
        'name',
        'file_name',
        'description',
        'price',
        'time_to_deliver',
        'ingredients',
        'avg_rating',
        'rating_count',
    ];
}

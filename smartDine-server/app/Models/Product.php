<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
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

     public function getImageUrlAttribute(): string
    {
        return Storage::disk('s3')
                      ->url("products/{$this->file_name}");
    }

    /**
     * If you have AR models, same pattern for the 3D asset:
     */
    public function getArModelUrlAttribute(): ?string
    {
        return $this->ar_model_file
            ? Storage::disk('s3')
                     ->url("ar-models/{$this->ar_model_file}")
            : null;
    }
}

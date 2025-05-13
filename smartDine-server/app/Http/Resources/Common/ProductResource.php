<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        $price = $this->override_price != null ? $this->override_price : $this->price; 
<<<<<<< HEAD
        $description = $this->description != null ? $this->override_description : $this->description;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
=======
        $description = $this->override_description != null ? $this->override_description : $this->description;
        return [
            'id' => $this->id,
            'name' => $this->name,
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            'description' => $description,
            'price' => '$' . $price,
            'time_to_deliver' => $this->time_to_deliver,
            'ingredients' => $this->ingredients,
<<<<<<< HEAD
            'avg_rating' => $this->avg_rating,
            'rating_count' => $this->rating_count,
=======

            'image_url' => 'https://placehold.co/150x150',
            'ar_model_url' => 'hello'
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}

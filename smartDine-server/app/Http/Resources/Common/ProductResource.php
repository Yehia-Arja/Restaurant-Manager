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
        $description = $this->description != null ? $this->override_description : $this->description;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'description' => $description,
            'price' => '$' . $price,
            'time_to_deliver' => $this->time_to_deliver,
            'ingredients' => $this->ingredients,
            'avg_rating' => $this->avg_rating,
            'rating_count' => $this->rating_count,

            'image_url' => $this->image_url,
            'ar_model_url' => $this->ar_model_url,
        ];
    }
}

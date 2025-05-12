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
        $description = $this->override_description != null ? $this->override_description : $this->description;
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $description,
            'price' => '$' . $price,
            'time_to_deliver' => $this->time_to_deliver,
            'ingredients' => $this->ingredients,

            'image_url' => 'https://placehold.co/150x150',
            'ar_model_url' => 'kll'
        ];
    }
}

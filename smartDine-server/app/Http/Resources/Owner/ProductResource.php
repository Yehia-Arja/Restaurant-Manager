<?php

namespace App\Http\Resources\Owner;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'file_name' => $this->file_name,
            'description' => $this->description,
            'price' => '$' . $this->price,
            'time_to_deliver' => $this->time_to_deliver,
            'ingredients' => $this->ingredients,
            'avg_rating' => $this->avg_rating,
            'rating_count' => $this->rating_count,
        ];
    }
}

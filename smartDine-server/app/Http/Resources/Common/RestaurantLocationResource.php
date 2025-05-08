<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantLocationResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'restaurant_id' => $this->restaurant_id,
            'location_name' => $this->location_name,
            'address'       => $this->address,
            'city'          => $this->city,
        ];
    }
}

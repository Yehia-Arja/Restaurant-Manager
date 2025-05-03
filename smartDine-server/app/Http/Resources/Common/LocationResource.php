<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'location_name'  => $this->location_name,
            'address'        => $this->address,
            'city'           => $this->city,
            'restaurant_id'  => $this->restaurant_id,
        ];
    }
}

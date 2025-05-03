<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'owner_id'    => $this->owner_id,
            'name'        => $this->name,
            'file_name'   => $this->file_name,
            'description' => $this->description,
        ];
    }
}

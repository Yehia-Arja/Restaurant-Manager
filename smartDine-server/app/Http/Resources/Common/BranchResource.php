<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class BranchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'               => $this->id,
            'location_name'    => $this->location_name,
            'address'          => $this->address,
            'city'             => $this->city,
        ];
    }
}

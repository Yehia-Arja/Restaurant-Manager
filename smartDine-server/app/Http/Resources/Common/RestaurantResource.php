<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Common\MediaService;

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
            'image_url'   => MediaService::url($this->file_name, 'restaurants'),
            'description' => $this->description,
        ];
    }
}

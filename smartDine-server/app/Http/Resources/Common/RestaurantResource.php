<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
<<<<<<< HEAD
=======
use App\Services\Common\MediaService;
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d

class RestaurantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
<<<<<<< HEAD
            'owner_id'    => $this->owner_id,
            'name'        => $this->name,
            'file_name'   => $this->file_name,
            'description' => $this->description,
=======
            'name'        => $this->name,
            'image_url'   => 'https://placehold.co/150x150',
            'description' => $this->description,
            'is_favorite' => $this->is_favorite ?? false,
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}

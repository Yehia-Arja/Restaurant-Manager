<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
<<<<<<< HEAD
=======
use App\Services\Common\MediaService;
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
<<<<<<< HEAD
            'file_name'     => $this->file_name,
            'restaurant_id' => $this->restaurant_id,
=======
            'image_url'     => 'https://placehold.co/150x150',
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        ];
    }
}

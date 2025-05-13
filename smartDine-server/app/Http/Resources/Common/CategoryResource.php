<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Services\Common\MediaService;

class CategoryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'image_url'     => 'https://placehold.co/150x150',
        ];
    }
}

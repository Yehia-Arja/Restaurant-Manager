<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class TableResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'number'      => $this->number,
            'floor'       => $this->floor,
            'position'    => json_decode($this->position, true),
            'num_chairs'  => $this->chairs_count ?? $this->chairs()->count(),
            'is_occupied' => ($this->occupied_chairs_count ?? $this->chairs()->where('is_occupied', true)->count()) > 0,
        ];
    }
}

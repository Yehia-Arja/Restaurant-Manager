<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Common\ProductResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id'                     => $this->id,
<<<<<<< HEAD
            'user_id'                => $this->user_id,
=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            'product_id'             => $this->product_id,
            'table_id'               => $this->table_id,
            'restaurant_location_id' => $this->restaurant_location_id,
            'status'                 => $this->status,
            'created_at'             => $this->created_at->toDateTimeString(),
<<<<<<< HEAD
            'updated_at'             => $this->updated_at->toDateTimeString(),
=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d

            'product'                => new ProductResource($this->whenLoaded('product')),

        ];
    }
}

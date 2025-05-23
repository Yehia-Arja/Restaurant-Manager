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
            'product_id'             => $this->product_id,
            'table_id'               => $this->table_id,
            'restaurant_location_id' => $this->restaurant_location_id,
            'status'                 => 'pending',
            'created_at'             => $this->created_at->toDateTimeString(),

            'product'                => new ProductResource($this->whenLoaded('product')),

        ];
    }
}

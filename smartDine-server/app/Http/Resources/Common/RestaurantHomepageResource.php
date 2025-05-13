<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantHomepageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'branches'        => LocationResource::collection($this->resource['branches']),
            'selected_branch' => new LocationResource($this->resource['selected_branch']),
            'categories'      => CategoryResource::collection($this->resource['categories']),
            'products'        => ProductResource::collection($this->resource['products']),
        ];
    }
}

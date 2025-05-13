<?php

namespace App\Http\Resources\Common;

use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantHomepageResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
<<<<<<< HEAD
            'restaurant'      => new RestaurantResource($this->resource['restaurant']),
=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
            'branches'        => LocationResource::collection($this->resource['branches']),
            'selected_branch' => new LocationResource($this->resource['selected_branch']),
            'categories'      => CategoryResource::collection($this->resource['categories']),
            'products'        => ProductResource::collection($this->resource['products']),
        ];
    }
}

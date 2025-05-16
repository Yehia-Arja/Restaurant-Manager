<?php

namespace App\Services\Common;

use App\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{


    /**
     * List categories, filtered optionally by branch or by restaurant.
     *
     * @param  int|null  $branchId
     * @param  int|null  $restaurantId
     */
    public static function list(
        ?int $branchId     = null,
        ?int $restaurantId = null
    ) {
        $q = Category::query();

        if ($branchId) {
            // only those categories made available at this branch
            $q->select('categories.*')
              ->join('locationables as loc', function($join) use ($branchId) {
                  $join->on('loc.locationable_id', '=', 'categories.id')
                       ->where('loc.locationable_type',  'App\Models\Category')
                       ->where('loc.restaurant_location_id', $branchId);
              });
        }
        elseif ($restaurantId) {
            // brand level list of all categories for that restaurant
            $q->where('restaurant_id', $restaurantId);
        }

        return $q->get();
    }
}

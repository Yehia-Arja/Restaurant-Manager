<?php

namespace App\Services\Common;

use App\Models\Restaurant;

class RestaurantService
{
    public static function getAllRestaurants()
    {
        return Restaurant::whereHas('locations')->get();
    }

    public static function getRestaurantHomepage(int $restaurantId, ?int $branchId = null): ?array
    {
        $restaurant = Restaurant::with('locations')->find($restaurantId);

        if (!$restaurant || $restaurant->locations->isEmpty()) {
            return null;
        }

        $branches = $restaurant->locations;
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

        $products   = ProductService::list($selected->id);
        $categories = CategoryService::list($selected->id);

        return [
            'restaurant'      => $restaurant,
            'branches'        => $branches,
            'selected_branch' => $selected,
            'categories'      => $categories,
            'products'        => $products,
        ];
    }
}

<?php

namespace App\Services\Common;

use App\Models\Restaurant;
use App\Services\Common\ProductService;

class RestaurantService
{
    /**
     * Fetch every restaurant that has at least one branch.
     */
    public static function getAllRestaurants()
    {
        return Restaurant::whereHas('locations')->get();
    }

    /**
     * Fetch the “homepage” payload for one restaurant:
     *  - its own record
     *  - all branches
     *  - a selected branch (first or overridden)
     *  - that branch’s products (using ProductService)
     *
     * Returns null if not found.
     */
    public static function getRestaurantHomepage(int $restaurantId, ?int $branchId = null): ?array
    {
        // Load restaurant + branches
        $restaurant = Restaurant::with('locations')
                                ->find($restaurantId);

        if (!$restaurant || $restaurant->locations->isEmpty()) {
            return null;
        }

        // Pick which branch to show
        $branches = $restaurant->locations;
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

        // Fetch products for that branch
        $products = ProductService::list($selected->id);

        return [
            'restaurant'      => $restaurant,
            'branches'        => $branches,
            'selected_branch' => $selected,
            'products'        => $products,
        ];
    }
}

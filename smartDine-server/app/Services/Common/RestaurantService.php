<?php

namespace App\Services\Common;

use App\Models\Restaurant;
use App\Services\Common\ProductService;
use App\Services\Common\CategoryService;

class RestaurantService
{
    public static function upsert(array $data): Restaurant
    {
        return Restaurant::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'owner_id'    => $data['owner_id'],
                'name'        => $data['name'],
                'file_name'   => $data['file_name'],
                'description' => $data['description'] ?? null,
            ]
        );
    }

    /**
     * Delete a restaurant by ID.
     */
    public static function deleteRestaurant(int $id): bool
    {
        return Restaurant::destroy($id) > 0;
    }
    /**
     * Fetch every restaurant that has at least one branch.
     *
     * @return \Illuminate\Support\Collection<Restaurant>
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
     *  - that branch’s products
     *  - that branch’s categories
     *
     * Returns null if not found.
     *
     * @param  int      $restaurantId
     * @param  int|null $branchId
     * @return array|null
     */
    public static function getRestaurantHomepage(int $restaurantId, ?int $branchId = null): ?array
    {
        // Load restaurant + its branches
        $restaurant = Restaurant::with('locations')->find($restaurantId);

        if (!$restaurant || $restaurant->locations->isEmpty()) {
            return null;
        }

        // Decide which branch to select
        $branches = $restaurant->locations;
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

        // Fetch products & categories for that branch
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

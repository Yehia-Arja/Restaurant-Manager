<?php
namespace App\Services\Common;

use App\Models\Restaurant;
use App\Services\CategoryService;
use App\Services\Owner\ProductService;
use Illuminate\Support\Collection;

class RestaurantService
{
    /**
     * Fetch every restaurant that has at least one branch.
     */
    public static function getAllRestaurants(): Collection
    {
        return Restaurant::whereHas('locations')
                         ->get();
    }

    /**
     * Fetch a restaurant plus:
     *  - its branches
     *  - a selected branch (first or overridden)
     *  - that branch’s categories
     *  - that branch’s products
     *
     * Returns null if restaurant not found or no branches.
     */
    public static function getRestaurantBranchDetails(
        int     $id,
        ?int    $branchId    = null,
    ): ?array
    {
        // Find a restaurant that actually has branches
        $restaurant = Restaurant::where('id', $id)
                                ->whereHas('locations')
                                ->first();

        if (!$restaurant) {
            return null;
        }

        $branches = $restaurant->locations;
        if ($branches->isEmpty()) {
            return null;
        }

        // Determine which branch to select
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

        return [
            'restaurant'      => $restaurant,
            'branches'        => $branches,
            'selected_branch' => $selected,
        ];
    }
}

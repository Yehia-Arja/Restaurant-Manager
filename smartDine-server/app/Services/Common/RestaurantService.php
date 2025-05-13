<?php

namespace App\Services\Common;

use App\Models\Restaurant;
<<<<<<< HEAD
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
=======
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class RestaurantService
{

    public static function filterRestaurants(?string $search = null, bool $favoritesOnly = false, int $perPage = 10)
    {
        $query = Restaurant::with('locations');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($favoritesOnly && Auth::check()) {
            $userId = Auth::id();
            $query->whereHas('favorites', fn ($q) => $q->where('user_id', $userId));
        }

        $restaurants = $query->paginate($perPage);

        // Add is_favorite manually
        if (Auth::check()) {
            $userId = Auth::id();
            $favoriteIds = Favorite::where('user_id', $userId)
                ->where('favoritable_type', Restaurant::class)
                ->pluck('favoritable_id')
                ->toArray();

            $restaurants->getCollection()->transform(function ($restaurant) use ($favoriteIds) {
                $restaurant->is_favorite = in_array($restaurant->id, $favoriteIds);
                return $restaurant;
            });
        }

        return $restaurants;
    }
        
    public static function getRestaurantHomepage(int $restaurantId, ?int $branchId = null): ?array
    {
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        $restaurant = Restaurant::with('locations')->find($restaurantId);

        if (!$restaurant || $restaurant->locations->isEmpty()) {
            return null;
        }

<<<<<<< HEAD
        // Decide which branch to select
=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        $branches = $restaurant->locations;
        $selected = $branchId
            ? $branches->firstWhere('id', $branchId)
            : $branches->first();

        if (!$selected) {
            return null;
        }

<<<<<<< HEAD
        // Fetch products & categories for that branch
=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
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

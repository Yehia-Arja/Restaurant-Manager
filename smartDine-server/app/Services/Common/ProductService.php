<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Models\Category;

class ProductService
{
    /**
     * Fetch products with optional filtering by branch (location), restaurant, category, or search term.
     * Uses the 'locations' relation (morph-pivot) to filter by branch and load override pivots.
     */
    public static function list(
        ?int $branchId = null,
        ?int $restaurantId = null,
        ?int $userId = null,
        bool $favoritesOnly = false
    ) {
        $q = Category::query();
    
        if ($branchId) {
            $q->select('categories.*')
              ->join('locationables as loc', function ($join) use ($branchId) {
                  $join->on('loc.locationable_id', '=', 'categories.id')
                       ->where('loc.locationable_type', 'Category')
                       ->where('loc.restaurant_location_id', $branchId);
              });
        } elseif ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        }
    
        if ($favoritesOnly && $userId) {
            $q->whereIn('id', function ($sub) use ($userId) {
                $sub->select('favoritable_id')
                    ->from('favorites')
                    ->where('favoritable_type', Category::class)
                    ->where('user_id', $userId);
            });
        }
    
        return $q->get();
    }
    /**
     * Fetch a single product by its ID, including its locations and override pivots.
     */    

    public static function getById(int $id): Product
    {
        return Product::with(['locations' => function ($q) {
            $q->withPivot(['override_price', 'override_description']);
        }])->findOrFail($id);
    }
}
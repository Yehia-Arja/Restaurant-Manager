<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
        ?int $categoryId = null,
        ?bool $favoritesOnly = false,
        ?string $search = null
    ) {
        $q = Product::query();
    
        // Filter by category
        if ($categoryId) {
            $q->where('category_id', $categoryId);
        }
    
        // Filter by branch (morph relationship: locations)
        if ($branchId) {
            $q->whereHas('locations', function ($query) use ($branchId) {
                $query->where('restaurant_location_id', $branchId);
            });
        }
    
        // Filter by restaurant
        if ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        }
    
        // Filter by user favorites
        if ($favoritesOnly) {
            $userId = Auth::id();
            $q->whereIn('id', function ($sub) use ($userId) {
                $sub->select('favoritable_id')
                    ->from('favorites')
                    ->where('favoritable_type', Product::class)
                    ->where('user_id', $userId);
            });
        }
    
        // Apply search (on name/description)
        if ($search) {
            $q->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }
    
        // Eager load locations + override
        $q->with(['locations' => function ($q) {
            $q->withPivot(['override_price', 'override_description']);
        }]);
    
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
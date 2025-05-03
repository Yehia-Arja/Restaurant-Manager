<?php

namespace App\Services\Common;

use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    /**
     * Create a new or update product.
     */
    public static function upsert(array $data): Product
    {
        // Create or update the product
        return Product::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'restaurant_id'    => $data['restaurant_id'],
                'name'             => $data['name'],
                'description'      => $data['description'] ?? null,
                'file_name'        => $data['file_name'] ?? null,
                'category_id'      => $data['category_id'] ?? null,
                'price'            => $data['price'],
            ]
        );
    }

    
    public static function delete(int $id): bool
    {
        // Delete the product by ID
        return Product::destroy($id) > 0;
    }

    /**
     * Fetch a product by ID.
     */
    public static function getById(int $id)
    {
        return Product::find($id);
    }

    /**
     * Fetch products at a restaurant or available at a branch, with optional category & search filters.
     * Always returns override_price & override_description from the pivot.
     */
    public static function list(
        ?int $branchId = null,
        ?int $restaurantId = null,
        ?int $categoryId = null,
        ?string $search     = null
    ): Collection {
        if (!$branchId && !$restaurantId) {
            return collect(); 
        }
        $q = Product::query();

        // Branch‐specific (with overrides)
        if ($branchId) {
            $q->select([
                    'products.*',
                    'loc.override_price',
                    'loc.override_description',
                ])
              ->join('locationables as loc', function($join) use ($branchId) {
                  $join->on('loc.locationable_id', '=', 'products.id')
                       ->where('loc.locationable_type', 'Product')
                       ->where('loc.restaurant_location_id', $branchId);
              });
        }
        // Restaurant‐wide
        elseif ($restaurantId) {
            $q->where('restaurant_id', $restaurantId);
        }

        // Optional category filter
        if ($categoryId) {
            $q->where('products.category_id', $categoryId);
        }

        // Optional search by name OR tag
        if ($search) {
            $q->where(function($sub) use ($search) {
                $sub->where('products.name', 'like', "%{$search}%")
                    ->orWhereIn('products.id', function($inner) use ($search) {
                        $inner->select('product_id')
                              ->from('product_tags')
                              ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                              ->where('tags.name', 'like', "%{$search}%");
                    });
            });
        }

        return $q->get();
    }
}
<?php

namespace App\Http\Controllers\Common;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Owner\ProductResource;

class CommonProductController extends Controller
{
    /**
     * Fetch products for a branch, optionally filtered by category or search,
     * and always include the branch-specific override_price & override_description.
     */
    public function index(Request $request)
    {
        $branchId   = $request->query('restaurant_location_id');
        $categoryId = $request->query('category_id');
        $search = $request->query('search');

        // Build a query that joins the pivot and selects override columns
        $query = Product::select([
                'products.*',
                'loc.override_price',
                'loc.override_description',
            ])
            ->join('locationables as loc', function($join) use ($branchId) {
                $join->on('loc.locationable_id', '=', 'products.id')
                     ->where('loc.locationable_type',   'Product')
                     ->where('loc.restaurant_location_id', $branchId);
            });

        // Category filter
        if ($categoryId) {
            $query->where('products.category_id', $categoryId);
        }

        // Name/tag search
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('products.name', 'like', "%{$search}%")
                  ->orWhereIn('products.id', function($sub) use ($search) {
                      $sub->select('product_id')
                          ->from('product_tags')
                          ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                          ->where('tags.name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->get();

        return $this->success(
            'Products fetched successfully',
            ProductResource::collection($products)
        );
    }
}

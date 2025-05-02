<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Owner\ProductResource;
use App\Http\Requests\Owner\CreateProductRequest;
use App\Http\Requests\Owner\UpdateProductRequest;
use App\Services\Owner\ProductService;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * (Common) GET  /api/v0.1/common/product
     * Any logged-in user: fetch products for a branch,
     * filter by category or search, always include overrides.
     */
    public function commonIndex(Request $request)
    {
        $data = $request->validate([
            'restaurant_location_id' => 'required|exists:restaurant_locations,id',
            'category_id'            => 'sometimes|exists:categories,id',
            'search'                 => 'sometimes|string',
        ]);

        $branchId   = $data['restaurant_location_id'];
        $categoryId = $data['category_id'] ?? null;
        $searchTerm = $data['search']      ?? null;

        $products = Product::select([
                'products.*',
                'loc.override_price',
                'loc.override_description',
            ])
            ->join('locationables as loc', function($join) use ($branchId) {
                $join->on('loc.locationable_id', '=', 'products.id')
                     ->where('loc.locationable_type',       'Product')
                     ->where('loc.restaurant_location_id', $branchId);
            })
            ->when($categoryId, fn($q) =>
                $q->where('products.category_id', $categoryId)
            )
            ->when($searchTerm, function($q) use ($searchTerm) {
                $q->where('products.name', 'like', "%{$searchTerm}%")
                  ->orWhereIn('products.id', function($sub) use ($searchTerm) {
                      $sub->select('product_id')
                          ->from('product_tags')
                          ->join('tags', 'tags.id', '=', 'product_tags.tag_id')
                          ->where('tags.name', 'like', "%{$searchTerm}%");
                  });
            })
            ->get();

        return $this->success(
            'Products fetched successfully (common)',
            ProductResource::collection($products)
        );
    }

    /**
     * (Owner)   GET  /api/v0.1/owner/product
     * Only owners: fetch all products for one of their restaurants.
     */
    public function ownerIndex(Request $request)
    {
        $owner        = Auth::user();
        $restaurantId = $request->query('restaurant_id');

        if (!$owner->restaurants()->where('id', $restaurantId)->exists()) {
            return $this->error('Unauthorized access to this restaurant', 403);
        }

        $products = Product::where('restaurant_id', $restaurantId)
                           ->get();

        return $this->success(
            'Products fetched successfully (owner)',
            ProductResource::collection($products)
        );
    }

    /**
     * (Owner) POST /api/v0.1/owner/product
     */
    public function store(CreateProductRequest $request)
    {
        $data = ProductService::createProduct($request->validated());

        if (! $data) {
            return $this->error('Product creation failed', 500);
        }

        return $this->success(
            'Product created successfully',
            ProductResource::collection($data)
        );
    }

    /**
     * (Owner) GET   /api/v0.1/owner/product/{product}
     */
    public function show(Product $product)
    {
        return $this->success(
            'Product fetched successfully',
            ProductResource::collection($product)
        );
    }

    /**
     * (Owner) PUT   /api/v0.1/owner/product/{product}
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = ProductService::updateProduct($product, $request->validated());

        if (!$updated) {
            return $this->error('Product update failed', 500);
        }

        return $this->success(
            'Product updated successfully',
            ProductResource::collection($updated)
        );
    }

    /**
     * (Owner) DELETE /api/v0.1/owner/product/{product}
     */
    public function destroy(Product $product)
    {
        if (! $product->delete()) {
            return $this->error('Product deletion failed', 500);
        }

        return $this->success('Product deleted successfully');
    }
}

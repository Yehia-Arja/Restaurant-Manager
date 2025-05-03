<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Owner\ProductResource;
use App\Services\COmmon\ProductService;
use App\Http\Requests\Common\ProductRequest;
use App\Http\Requests\Owner\CreateProductRequest;
use App\Http\Requests\Owner\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * (Common) GET /api/v0.1/common/products
     * — any logged-in user may call this to fetch/filter/search by branch.
     */
    public function commonIndex(ProductRequest $request)
    {
        $data = $request->validate([
            'restaurant_location_id' => 'required|exists:restaurant_locations,id',
            'category_id'            => 'sometimes|exists:categories,id',
            'search'                 => 'sometimes|string',
        ]);

        $products = ProductService::forBranch(
            $data['restaurant_location_id'],
            $data['category_id'] ?? null,
            $data['search']      ?? null
        );

        return $this->success(
            'Products fetched',
            ProductResource::collection($products)
        );
    }

    /**
     * (Owner) GET /api/v0.1/owner/product
     * — owner may list *all* products for one of their restaurants.
     */
    public function ownerIndex(Request $request)
    {
        $owner        = Auth::user();
        $restaurantId = $request->query('restaurant_id');

        if (!$owner->restaurants()->where('id', $restaurantId)->exists()) {
            return $this->error('Forbidden', 403);
        }

        $products = ProductService::forOwner($restaurantId);

        return $this->success(
            'Products fetched',
            ProductResource::collection($products)
        );
    }

    /**
     * (Owner) POST /api/v0.1/owner/product
     */
    public function store(CreateProductRequest $request)
    {
        $product = ProductService::createProduct($request->validated());

        return $this->success(
            'Product created',
            new ProductResource($product)
        );
    }

    /**
     * (Owner) GET /api/v0.1/owner/product/{product}
     */
    public function show(Product $product)
    {
        return $this->success(
            'Product details',
            new ProductResource($product)
        );
    }

    /**
     * (Owner) PUT /api/v0.1/owner/product/{product}
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $updated = ProductService::updateProduct($product, $request->validated());

        return $this->success(
            'Product updated',
            new ProductResource($updated)
        );
    }

    /**
     * (Owner) DELETE /api/v0.1/owner/product/{product}
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->success('Product deleted');
    }
}

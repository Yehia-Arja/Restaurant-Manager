<?php

namespace App\Http\Controllers\Common;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\Common\ProductResource;
use App\Services\Common\ProductService;
use App\Http\Requests\Common\ProductRequest;
use App\Http\Requests\Owner\CreateOrUpdateProductRequest;
use App\Http\Requests\Owner\UpdateProductRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(ProductRequest $request)
    {
        $data = $request->validated();

        $products = ProductService::list(
            $data['restaurant_location_id'] ?? null,
            $data['restaurant_id']          ?? null,
            $data['category_id']            ?? null,
            $data['search']                 ?? null
        );

        if ($products->isEmpty()) {
            return $this->error('No products found', 404);
        }
        
        return $this->success(
            'Products fetched',
            ProductResource::collection($products)
        );
    }
    /**
     * (Owner) POST /api/v0.1/owner/product
     */
    public function store(CreateOrUpdateProductRequest $request)
    {
        $data = $request->validated();
        $product = ProductService::upsert($data);

        if (!$product) {
            return $this->error('Product creation failed', 500);
        }

        return $this->success(
            'Product created',
            new ProductResource($product)
        );
    }

    /**
     * (Owner) GET /api/v0.1/owner/product/{product}
     */
    public function show(int $id)
    {
        $product = ProductService::getById($id);

        if (!$product) {
            return $this->error('Product not found', 404);
        }

        return $this->success(
            'Product details',
            new ProductResource($product)
        );
    }

    /**
     * (Owner) PUT /api/v0.1/owner/product/{product}
     */
    public function update(CreateOrUpdateProductRequest $request, int $id)
    {
        $data = $request->validated();
        $data['id'] = $id;

        $updated = ProductService::upsert($data);

        if (!$updated) {
            return $this->error('Product update failed', 500);
        }

        return $this->success(
            'Product updated',
            new ProductResource($updated)
        );
    }

    /**
     * (Owner) DELETE /api/v0.1/owner/product/{product}
     */
    public function destroy(int $id)
    {
        $response = ProductService::delete($id);

        if (!$response) {
            return $this->error('Product deletion failed', 500);
        }

        return $this->success('Product deleted');
    }
}

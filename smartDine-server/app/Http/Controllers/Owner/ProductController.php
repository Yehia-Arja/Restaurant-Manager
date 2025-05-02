<?php

namespace App\Http\Controllers\Owner;

use App\Models\Product;
use App\Http\Resources\Owner\ProductResource;
use App\Http\Controllers\Controller;
use GuzzleHttp\Promise\Create;
use App\Http\Requests\Owner\UpdateProductRequest;
use App\Services\Owner\ProductService;
use App\Http\Requests\Owner\CreateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $owner = Auth::user();
        $restaurantId = $request->query('restaurant_id');

        // Validate restaurant belongs to this owner
        if (!$owner->restaurants()->where('id', $restaurantId)->exists()) {
            return $this->error('Unauthorized access to this restaurant', 403);
        }

        // Fetch products for that specific restaurant
        $products = Product::where('restaurant_id', $restaurantId)->get();

        return $this->success('Products fetched successfully', ProductResource::collection($products));
    }
    
     /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        // Validate the request
        $validatedData = $request->validated();

        $data = ProductService::createProduct($validatedData);

        if (!$data) {
            return $this->error('Product creation failed', 500);
        }

        return $this->success('Product created successfully', $data);

    }
    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->success('Product fetched successfully', $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $validatedData = $request->validated();

        $updated = ProductService::updateProduct($product, $validatedData);

        if (!$updated) {
            return $this->error('Product update failed', 500);
        }

        return $this->success('Product updated successfully', $updated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$product->delete()) {
            return $this->error('Product deletion failed', 500);
        }

        return $this->success('Product deleted successfully');
    }
}

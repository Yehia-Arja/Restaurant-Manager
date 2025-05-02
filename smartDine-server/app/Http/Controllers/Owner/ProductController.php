<?php

namespace App\Http\Controllers;

use App\Models\Product;
use GuzzleHttp\Promise\Create;
use App\Services\ProductService;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the owner has a restaurant
        $owner = Auth::user();
        if (!$owner->restaurant) {
            return $this->error('Owner does not have a restaurant', 404);
        }

        // Fetch products for the restaurant
        $products = Product::where('restaurant_id', $owner->restaurant->id)->get();

        // Return the products
        return $this->success('Products fetched successfully', $products);
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
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
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

<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\CategoryRequest;
use App\Http\Requests\Owner\CreateOrUpdateCategoryRequest;
use App\Models\Category;
use App\Services\Common\CategoryService;
use App\Http\Resources\Common\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CategoryRequest $request)
    {
        
        $data = $request->validated();

        $categories = CategoryService::list(
            $data['restaurant_id'],
            $data['branch_id'],
        );
        
        if ($categories->isEmpty()) {
            return $this->error('No categories found', 404);
        }

        return $this->success(
            'Categories fetched',
            CategoryResource::collection($categories)
        );
    }

    /**
     * Store a newly created category.
     */
    public function store(CreateOrUpdateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = CategoryService::upsert($data);

        return $this->success(
            'Category created',
            new CategoryResource($category)
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdateCategoryRequest $request)
    {
        $data = $request->validated();

        $category = CategoryService::upsert($data);

        return $this->success(
            'Category updated',
            new CategoryResource($category)
        );
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $response = CategoryService::delete($category->id);

        if (!$response) {
            return $this->error('Category not found', 404);
        }

        return $this->success(
            'Category deleted',
            new CategoryResource($category)
        );
    }
}

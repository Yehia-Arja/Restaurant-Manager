<?php

namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateCategoryRequest;
use App\Models\Category;
use App\Services\Owner\CategoryService; 
use App\Http\Resources\Common\CategoryResource;
use App\Http\Requests\Owner\CategoryRequest;        

class CategoryController extends Controller
{
    /**
     * Store a newly created category.
     */
    public function store(CreateOrUpdateCategoryRequest $request)
    {
        try {
            $data = $request->validated();

            $category = CategoryService::upsert($data);

            return $this->success(
                'Category created',
                new CategoryResource($category)
            );
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateOrUpdateCategoryRequest $request, int $id)
    {
        try {
            $data = $request->validated();
            $data['id'] = $id;

            $category = CategoryService::upsert($data);

            if (!$category) {
                return $this->error('Category not found', 404);
            }

            return $this->success(
                'Category updated',
                new CategoryResource($category)
            );
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }  
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try {
            $response = CategoryService::deleteCategory($id);

            if (!$response) {
                return $this->error('Category not found', 404);
            }

            return $this->success('Category deleted');
        }catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
        
    }

}
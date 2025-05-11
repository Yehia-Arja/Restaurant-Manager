<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateCategoryRequest;
use App\Services\Owner\CategoryService;
use App\Http\Resources\Common\CategoryResource;
use Illuminate\Support\Facades\Log;
use Exception;

class CategoryController extends Controller
{
    /**
     * POST /api/v0.1/owner/categories
     */
    public function store(CreateOrUpdateCategoryRequest $request)
    {
        try {
            $category = CategoryService::create(
                $request->validated(),
                $request->file('image')
            );

            return $this->success(
                'Category created',
                new CategoryResource($category)
            );

        } catch (Exception $e) {
            Log::error('Error in CategoryController@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to create category', 500);
        }
    }

    /**
     * PUT /api/v0.1/owner/categories/{id}
     */
    public function update(CreateOrUpdateCategoryRequest $request, int $id)
    {
        try {
            $category = CategoryService::update(
                $id,
                $request->validated(),
                $request->file('image')
            );

            if (!$category) {
                return $this->error('Category not found', 404);
            }

            return $this->success(
                'Category updated',
                new CategoryResource($category)
            );

        } catch (Exception $e) {
            Log::error('Error in CategoryController@update', [
                'id'    => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to update category', 500);
        }
    }

    /**
     * DELETE /api/v0.1/owner/categories/{id}
     */
    public function destroy(int $id)
    {
        try {
            $deleted = CategoryService::delete($id);

            if (!$deleted) {
                return $this->error('Category not found', 404);
            }

            return $this->success('Category deleted');

        } catch (Exception $e) {
            Log::error('Error in CategoryController@destroy', [
                'id'    => $id,
                'error' => $e->getMessage(),
            ]);
            return $this->error('Failed to delete category', 500);
        }
    }
}

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
        try{
            $data = $request->validated();

            $categories = CategoryService::list(
                $data['restaurant_location_id'] ?? null,
                $data['restaurant_id'] ?? null,
            );
            
            if ($categories->isEmpty()) {
                return $this->error('No categories found', 404);
            }

            return $this->success(
                'Categories fetched',
                CategoryResource::collection($categories)
            );
        }catch(\Throwable $e){
            return $this->error($e->getMessage(), 500);
        }
        
    }

}

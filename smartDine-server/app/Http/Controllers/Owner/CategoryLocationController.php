<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\AttachBranchesRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryLocationController extends Controller
{
    /**
     * Link one or more branches to a category
     * POST /categories/{category}/locations
     */
    public function store(AttachBranchesRequest $request, Category $category): JsonResponse
    {
        $branchIds = $request->validated()['branch_ids'];

        // Attach branches without removing existing links
        $category->locations()->syncWithoutDetaching($branchIds);

        return $this->success(
            'Branches linked',
            $category->load('locations')
        )->setStatusCode(201);
    }

    /**
     * Unlink a branch from a category
     * DELETE /categories/{category}/locations/{branch}
     */
    public function destroy(Category $category, int $branchId): JsonResponse
    {
        $category->locations()->detach($branchId);

        return $this->success(
            'Branch unlinked',
            $category->load('locations')
        );
    }
}

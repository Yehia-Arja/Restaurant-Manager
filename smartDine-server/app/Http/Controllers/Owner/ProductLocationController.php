<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\AttachBranchesRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductLocationController extends Controller
{
    /**
     * Link one or more branches to a product
     * POST /products/{product}/locations
     */
    public function store(AttachBranchesRequest $request, Product $product): JsonResponse
    {
        $branchIds = $request->validated()['branch_ids'];

        // Attach branches without removing existing links
        $product->locations()->syncWithoutDetaching($branchIds);

        return $this->success(
            'Branches linked',
            $product->load('locations')
        );
    }

    /**
     * Unlink a branch from a product
     * DELETE /products/{product}/locations/{branch}
     */
    public function destroy(Product $product, $branchId): JsonResponse
    {
        $product->locations()->detach($branchId);

        return $this->success(
            'Branch unlinked',
            $product->load('locations')
        );
    }
}

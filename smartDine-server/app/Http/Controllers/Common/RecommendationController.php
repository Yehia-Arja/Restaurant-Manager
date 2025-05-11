<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Common\ProductResource;

class RecommendationController extends Controller
{
    public function index(Request $request)
    {
        $userId   = $request->user()->id;
        $branchId = $request->query('branch_id');
        $popular  = Cache::get("branch:{$branchId}:popular", collect());
        $forYou   = Cache::get("user:{$userId}:branch:{$branchId}:recs",     collect());

        return $this->success('Recommendations', [
            'popular' => ProductResource::collection($popular),
            'for_you' => ProductResource::collection($forYou),
        ]);
    }
}

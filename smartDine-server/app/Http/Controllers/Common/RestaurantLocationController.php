<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Models\Restaurant;
use App\Http\Resources\Common\BranchResource;

class RestaurantLocationController extends Controller
{

    /**
     * GET  /api/v0.1/common/restaurant/{id}/branches
     */
    public function branches(int $id)
    {
        try {
            $restaurant = Restaurant::with('locations')->find($id);

            if (!$restaurant) {
                return $this->error('Restaurant not found', 404);
            }

            $branches = $restaurant->locations;

            if ($branches->isEmpty()) {
                return $this->error('No branches found', 404);
            }

            return $this->success(
                'Branches fetched',
                BranchResource::collection($branches)
            );
        } catch (Exception $e) {
            Log::error("Error fetching branches for restaurant {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error('Failed to fetch branches', 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\FavoriteRequest;
use App\Services\Client\FavoriteService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class FavoriteController extends Controller
{
    /**
     * POST /api/v0.1/client/favorites/toggle
     */
    public function toggle(FavoriteRequest $request)
    {
        try {
            $userId = Auth::id();

            $wasFavorited = FavoriteService::toggleFavorite(
                $userId,
                $request->validated()['favoritable_id'],
                $request->validated()['favoritable_type']
            );

            return $this->success(
                $wasFavorited ? 'Added to favorites' : 'Removed from favorites'
            );
        } catch (Exception $e) {
            Log::error('FavoriteController@toggle error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error($e->getMessage(), 400);
        }
    }
}

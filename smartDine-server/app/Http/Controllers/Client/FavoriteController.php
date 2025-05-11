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
     * POST /api/v0.1/client/favorites
     */
    public function store(FavoriteRequest $request)
    {
        try {
            $userId = Auth::id();

            FavoriteService::addFavorite(
                $userId,
                $request->validated()['favoritable_id'],
                $request->validated()['favoritable_type']
            );

            return $this->success('Added to favorites');
        } catch (Exception $e) {
            Log::error('FavoriteController@store error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error($e->getMessage(), 400);
        }
    }

    /**
     * DELETE /api/v0.1/client/favorites
     */
    public function destroy(FavoriteRequest $request)
    {
        try {
            $userId = Auth::id();

            FavoriteService::removeFavorite(
                $userId,
                $request->validated()['favoritable_id'],
                $request->validated()['favoritable_type']
            );

            return $this->success('Removed from favorites');
        } catch (Exception $e) {
            Log::error('FavoriteController@destroy error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->error($e->getMessage(), 400);
        }
    }
}

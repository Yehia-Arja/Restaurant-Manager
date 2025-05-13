<?php

namespace App\Services\Client;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Restaurant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class FavoriteService
{
    public static function toggleFavorite(int $userId, int $favoritableId, string $favoritableType): bool
    {
        $typeClass = match ($favoritableType) {
            'product'    => Product::class,
            'restaurant' => Restaurant::class,
            default      => throw new Exception('Invalid favoritable type'),
        };

        // Check existence
        $model = $typeClass::find($favoritableId);
        if (!$model) {
            throw new Exception('Favoritable item not found');
        }

        // Toggle logic
        $existing = Favorite::where('user_id', $userId)
            ->where('favoritable_type', $typeClass)
            ->where('favoritable_id', $favoritableId)
            ->first();

        if ($existing) {
            $existing->delete();
            return false; // was removed
        }

        Favorite::create([
            'user_id'         => $userId,
            'favoritable_id'  => $favoritableId,
            'favoritable_type'=> $typeClass,
        ]);

        return true; // was added
    }
}

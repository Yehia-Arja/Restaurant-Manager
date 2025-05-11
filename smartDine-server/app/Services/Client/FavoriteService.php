<?php

namespace App\Services\Client;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\Restaurant;
use Exception;

class FavoriteService
{
    protected static array $allowedTypes = [
        'product' => Product::class,
        'restaurant' => Restaurant::class,
    ];

    public static function addFavorite(int $userId, int $favoritableId, string $favoritableType): void
    {
        $model = self::resolveType($favoritableType);

        if (!$model::find($favoritableId)) {
            throw new Exception('Item not found');
        }

        $exists = Favorite::where([
            'user_id' => $userId,
            'favoritable_id' => $favoritableId,
            'favoritable_type' => $model,
        ])->exists();

        if ($exists) {
            throw new Exception('Item already favorited');
        }

        Favorite::create([
            'user_id' => $userId,
            'favoritable_id' => $favoritableId,
            'favoritable_type' => $model,
        ]);
    }

    public static function removeFavorite(int $userId, int $favoritableId, string $favoritableType): void
    {
        $model = self::resolveType($favoritableType);

        $favorite = Favorite::where([
            'user_id' => $userId,
            'favoritable_id' => $favoritableId,
            'favoritable_type' => $model,
        ])->first();

        if (!$favorite) {
            throw new Exception('Item not favorited');
        }

        $favorite->delete();
    }

    private static function resolveType(string $type): string
    {
        if (!isset(self::$allowedTypes[$type])) {
            throw new Exception('Invalid favoritable type');
        }

        return self::$allowedTypes[$type];
    }
}

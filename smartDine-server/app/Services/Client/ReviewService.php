<?php
namespace App\Services\Common;

use App\Models\Review;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\RestaurantLocation;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use RuntimeException;

class ReviewService
{
    /**
     * @param  int         $userId
     * @param  string      $type 
     * @param  int         $id
     * @param  int         $rating
     * @param  string|null $comment
     * @return Review
     *
     * @throws ModelNotFoundException
     */
    public static function createReview(
        int $userId,
        string $type,
        int $id,
        int $rating,
        ?string $comment
    ): Review {
        $map = [
            'product'    => Product::class,
            'restaurant' => Restaurant::class,
            'branch'     => RestaurantLocation::class,
            'waiter'     => User::class,
        ];

        if (!isset($map[$type])) {
            throw new RuntimeException("Invalid reviewable type “{$type}”.");
        }

        $class = $map[$type];

        $class::findOrFail($id);

        return Review::create([
            'user_id'          => $userId,
            'reviewable_type'  => $class,
            'reviewable_id'    => $id,
            'rating'           => $rating,
            'comment'          => $comment,
        ]);
    }
}

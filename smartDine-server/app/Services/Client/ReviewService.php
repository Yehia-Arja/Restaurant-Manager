<?php

namespace App\Services\Client;

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
     * Create a new review for any reviewable type.
     *
     * @param  array  $data  [
     *     'user_id'          => int,
     *     'reviewable_type'  => string,   // one of: product, restaurant, branch, waiter
     *     'reviewable_id'    => int,
     *     'rating'           => int,      // 1–5
     *     'comment'          => string|null,
     * ]
     * @return Review
     *
     * @throws ModelNotFoundException
     * @throws RuntimeException
     */
    public static function createReview(array $data): Review
    {
        // map the incoming type to an Eloquent class
        $map = [
            'product'    => Product::class,
            'restaurant' => Restaurant::class,
            'branch'     => RestaurantLocation::class,
            'waiter'     => User::class,
        ];

        $type = strtolower($data['reviewable_type'] ?? '');
        $id   = $data['reviewable_id']   ?? null;

        if (! isset($map[$type]) || ! $id) {
            throw new RuntimeException("Invalid or missing reviewable_type/ID.");
        }

        $class = $map[$type];

        // make sure the thing exists
        $class::findOrFail($id);

        // persist the review
        return Review::create([
            'user_id'          => $data['user_id'],
            'reviewable_type'  => $class,
            'reviewable_id'    => $id,
            'rating'           => $data['rating'],
            'comment'          => $data['comment'] ?? null,
        ]);
    }
}

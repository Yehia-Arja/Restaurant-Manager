<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Order;
use App\Models\Restaurant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        static $userIds = null;
        static $orders = null;
        static $restaurants = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
        }

        if (is_null($orders)) {
            $orders = Order::pluck('id')->toArray();
        }

        if (is_null($restaurants)) {
            $restaurants = Restaurant::pluck('id')->toArray();
        }

        // Randomly decide which model type to review
        $type = $this->faker->randomElement(['order', 'restaurant']);

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'reviewable_id' => $type === 'order'
                ? $this->faker->randomElement($orders)
                : $this->faker->randomElement($restaurants),
            'reviewable_type' => $type === 'order'
                ? Order::class
                : Restaurant::class,
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $orderIds = null;
        static $locationIds = null;

        if (is_null($orderIds)) {
            $orderIds = Order::pluck('id')->toArray();
        }

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'rating' => $this->faker->numberBetween(1, 5),
            'comment' => $this->faker->optional()->sentence(),
            'order_id' => $this->faker->randomElement($orderIds),
            'restaurant_location_id' => $this->faker->randomElement($locationIds),
        ];
    }
}

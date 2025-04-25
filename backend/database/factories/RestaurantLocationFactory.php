<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Restaurant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RestaurantLocation>
 */
class RestaurantLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $restaurantIds = null;

        if (is_null($restaurantIds)) {
            $restaurantIds = Restaurant::pluck('id')->toArray();
        }

        return [
            'location_name' => $this->faker->streetName(),
            'address' => $this->faker->address(),
            'city' => $this->faker->city(),
            'restaurant_id' => $this->faker->randomElement($restaurantIds),
        ];
    }
}
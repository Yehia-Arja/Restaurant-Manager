<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Table>
 */
class TableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $locationIds = null;

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'position' => json_encode([
                'x' => $this->faker->numberBetween(0, 1000),
                'y' => $this->faker->numberBetween(0, 1000),
            ]),
            'floor' => $this->faker->numberBetween(0, 3),
            'restaurant_location_id' => $locationIds[array_rand($locationIds)],
        ];
    }
}
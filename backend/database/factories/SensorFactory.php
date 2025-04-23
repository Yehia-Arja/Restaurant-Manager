<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sensor>
 */
class SensorFactory extends Factory
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
            'restaurant_location_id' => $locationIds[array_rand($locationIds)],
        ];
    }
}

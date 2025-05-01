<?php

namespace Database\Factories;

use App\Models\RestaurantLocation;
use App\Models\Table;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chair>
 */
class ChairFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $locationIds = null;
        static $tableIds = null;
        static $sensorIds = null;

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        if (is_null($tableIds)) {
            $tableIds = Table::pluck('id')->toArray();
        }

        if (is_null($sensorIds)) {
            $sensorIds = Sensor::pluck('id')->toArray();
        }

        return [
            'position' => json_encode([
                'x' => $this->faker->numberBetween(0, 500),
                'y' => $this->faker->numberBetween(0, 500),
            ]),
            'restaurant_location_id' => $this->faker->randomElement($locationIds),
            'table_id' => $this->faker->randomElement($tableIds),
            'sensor_id' => $this->faker->unique()->randomElement($sensorIds),
        ];
    }
}

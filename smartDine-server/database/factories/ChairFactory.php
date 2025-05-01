<?php

namespace Database\Factories;

use App\Models\Table;
use App\Models\Sensor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chair>
 */
class ChairFactory extends Factory
{
    public function definition(): array
    {
        static $sensorIds = null;

        if (is_null($sensorIds)) {
            $sensorIds = Sensor::pluck('id')->toArray();
        }

        $table = Table::inRandomOrder()->first();

        return [
            'position' => json_encode([
                'x' => $this->faker->numberBetween(0, 1000),
                'y' => $this->faker->numberBetween(0, 1000),
            ]),
            'table_id' => $table->id,
            'sensor_id' => $this->faker->unique()->randomElement($sensorIds),
        ];
    }
}

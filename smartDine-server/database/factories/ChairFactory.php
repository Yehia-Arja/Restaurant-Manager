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
            'is_occupied' => $this->faker->boolean(30), // 30% chance to be occupied
            'table_id'    => $table->id,
            'sensor_id'   => $this->faker->unique()->randomElement($sensorIds),
        ];
    }
}

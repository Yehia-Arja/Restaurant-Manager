<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Table;
use App\Models\Sensor;

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
        static $tableIds = null;
        static $sensorIds = null;

        if (is_null($tableIds)) {
            $tableIds = Table::pluck('id')->toArray();
        }

        if (is_null($sensorIds)) {
            $sensorIds = Sensor::pluck('id')->toArray();
        }

        return [
            'position' => json_encode(['x' => rand(0, 500), 'y' => rand(0, 500)]),
            'table_id' => $tableIds[array_rand($tableIds)],
            'sensor_id' => $sensorIds[array_rand($sensorIds)],
        ];
    }
}

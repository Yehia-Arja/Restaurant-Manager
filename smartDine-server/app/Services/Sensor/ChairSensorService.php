<?php

namespace App\Services;

use App\Models\Chair;
use App\Models\Table;

class ChairSensorService
{
    public static function handleSensor(int $sensorId, float $value): void
    {
        $chair = Chair::where('sensor_id', $sensorId)->firstOrFail();

        // Flip chair state based on threshold
        $threshold = 0.5;
        $chair->is_occupied = $value > $threshold;
        $chair->save();

        // Check all chairs at that table
        $table = $chair->table;
        $anyOccupied = $table->chairs()->where('is_occupied', true)->exists();

        $table->is_occupied = $anyOccupied;
        $table->save();

    }
}

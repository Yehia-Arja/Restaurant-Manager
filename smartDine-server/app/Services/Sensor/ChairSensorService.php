<?php

namespace App\Services\Sensor;

use App\Models\Chair;
use App\Models\Table;
use App\Models\Sensor;

class ChairSensorService
{
    public static function handleSensor(int $sensorId, float $value)
    {
        $chair = Chair::where('sensor_id', $sensorId)->firstOrFail();
        $threshold = 0.5;

        // Flip chair
        $chair->is_occupied = $value > $threshold;
        $chair->save();

        // Update table
        $table = $chair->table;
        $anyOccupied = $table->chairs()->where('is_occupied', true)->exists();

        $table->is_occupied = $anyOccupied;
        $table->save();

        // Push to Node.js via HTTP or Redis event (next step)
    }
}

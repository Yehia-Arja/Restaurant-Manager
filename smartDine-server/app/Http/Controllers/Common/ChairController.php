<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Models\Sensor;
use Illuminate\Http\Request;
use App\Http\Requests\Common\SensorRequest;
use App\Services\Common\ChairSensorService;

class ChairController extends Controller
{
    public function flip(SensorRequest $request)
    {
        try {
            $data = $request->validated();
            
            ChairSensorService::handleSensor($data['sensor_id'], $data['value']);

            return $this->success('Chair status updated');
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}

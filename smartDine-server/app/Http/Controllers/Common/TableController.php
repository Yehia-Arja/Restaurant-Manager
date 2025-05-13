<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Services\Common\TableService;
use App\Http\Requests\Common\TableRequest;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TableRequest $request)
    {
        try {
            $data = $request->validated();

            $tables = TableService::getTableList(
                $data['restaurant_location_id'],
            );

            if ($tables->isEmpty()) {
                return $this->error('No tables found', 404);
            }

            return $this->success(
                'Tables fetched',
                $tables
            );

        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }

    }

}
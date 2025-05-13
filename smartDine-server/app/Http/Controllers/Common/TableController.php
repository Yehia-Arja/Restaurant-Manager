<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
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

            $tables = TableService::list(
                $data['branch_id'],
            );

            if ($tables->isEmpty()) {
                return $this->error('No tables found', 404);
            }

            return $this->success(
                'Tables fetched',
                TableResource::collection($tables)
            );

        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }

    }

}
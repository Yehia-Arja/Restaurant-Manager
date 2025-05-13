<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\Owner\CreateOrUpdateTableRequest;
use App\Services\Owner\TableService;
use Illuminate\Http\JsonResponse;
use Exception;

class TableController extends Controller
{
    public function store(CreateOrUpdateTableRequest $request): JsonResponse
    {
        try {
            $table = TableService::updateOrCreate($request->validated());

            return $this->success('Table created', $table);
        } catch (Exception $e) {
            return $this->error('Creation failed: ' . $e->getMessage(), 500);
        }
    }

    public function update(CreateOrUpdateTableRequest $request, int $tableId): JsonResponse
    {
        try {
            $table = TableService::updateOrCreate($request->validated(), $tableId);

            return $this->success('Table updated', $table);
        } catch (Exception $e) {
            return $this->error('Update failed: ' . $e->getMessage(), 500);
        }
    }

    public function destroy(int $tableId): JsonResponse
    {
        try {
            TableService::delete($tableId);

            return $this->success('Table deleted');
        } catch (Exception $e) {
            return $this->error('Delete failed: ' . $e->getMessage(), 500);
        }
    }
}

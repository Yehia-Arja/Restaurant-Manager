<?php

namespace App\Services\Owner;

use App\Models\Table;
use Illuminate\Support\Facades\DB;

class TableService
{
    public static function updateOrCreate(array $data, ?int $tableId = null): Table
    {
        
        return Table::updateOrCreate(
            ['id' => $tableId],
            [
                'restaurant_location_id' => $data['restaurant_location_id'],
                'number'                 => $data['number'],
                'floor'                  => $data['floor'],
                'position'               => json_encode($data['position']),
            ]
        );
        
    }

    public static function delete(int $tableId): bool
    {
        return DB::transaction(function () use ($tableId) {
            return Table::findOrFail($tableId)->delete();
        });
    }
}

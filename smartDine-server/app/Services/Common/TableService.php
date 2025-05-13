<?php

namespace App\Services\Common;

use App\Models\Table;

class TableService
{
    public static function getTableList(int $restaurantLocationId)
    {
        return Table::query()
            ->where('restaurant_location_id', $restaurantLocationId)

            // total chairs
            ->withCount('chairs')

            // count only occupied chairs
            ->withCount(['chairs as occupied_chairs_count' => function($q) {
                $q->where('is_occupied', true);
            }])
            ->orderBy('number')
            ->get()
            ->map(function (Table $table) {
                return [
                    'id'               => $table->id,
                    'number'           => $table->number,
                    'floor'            => $table->floor,
                    'position'         => json_decode($table->position, true),
                    'num_chairs'       => $table->chairs_count,
                    'is_occupied'      => $table->occupied_chairs_count > 0,
                ];
            });
    }
}

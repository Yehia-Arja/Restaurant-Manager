<?php

namespace App\Services\Common;

use App\Models\Table;
use Illuminate\Support\Collection;

class TableService
{
    public static function getTableList(int $restaurantLocationId, int $floor)
    {
        return Table::query()
            ->where('restaurant_location_id', $restaurantLocationId)
            ->where('floor', $floor)
            ->orderBy('number')
            ->get();
            
    }
}

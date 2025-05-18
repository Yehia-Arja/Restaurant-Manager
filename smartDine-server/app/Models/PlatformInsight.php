<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformInsight extends Model
{
    protected $primaryKey = 'month';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'month',
        'owners_count',
        'clients_count',
        'new_clients_count',
        'clients_growth_pct',
        'restaurants_count',
        'new_restaurants_count',
        'restaurants_growth_pct',
        'products_count',
        'occupied_tables_count',
        'total_orders_count',
        'completed_orders_count',
        'orders_completion_pct',
        'total_revenue',
    ];
}

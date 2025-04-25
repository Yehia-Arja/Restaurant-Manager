<?php

namespace Database\Seeders;

use App\Models\Chair;
use App\Models\Table;
use App\Models\Sensor;
use App\Models\RestaurantLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chair::factory()->count(50)->create();
    }
}

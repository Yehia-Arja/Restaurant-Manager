<?php

namespace Database\Seeders;

use App\Models\RestaurantLocation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RestaurantLocation::factory()->count(50)->create();
    }
}

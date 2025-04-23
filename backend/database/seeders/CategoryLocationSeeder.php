<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoryLocation;

class CategoryLocationSeeder extends Seeder
{
    public function run(): void
    {
        CategoryLocation::factory()->count(50)->create();
    }
}

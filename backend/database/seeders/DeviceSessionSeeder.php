<?php

namespace Database\Seeders;

use App\Models\DeviceSession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DeviceSession::factory()->count(50)->create();
    }
}

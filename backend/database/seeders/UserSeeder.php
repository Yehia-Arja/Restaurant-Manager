<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'user_type_id' => 1,
        ]);

        // Owner
        User::create([
            'name' => 'Owner User',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password'),
            'user_type_id' => 2,
            'restaurant_location_id' => 1,
        ]);

        // Clients and Waiters
        User::factory()->count(100)->create();
    }
}

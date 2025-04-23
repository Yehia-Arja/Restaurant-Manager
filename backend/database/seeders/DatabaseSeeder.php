<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTypeSeeder::class,
            UserSeeder::class,
            RestaurantSeeder::class,
            RestaurantLocationSeeder::class,
            CategorySeeder::class,
            TagSeeder::class,
            CategoryLocationSeeder::class,
            ProductSeeder::class,
            ProductLocationSeeder::class,
            SensorSeeder::class,
            TableSeeder::class,
            ChairSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
            FavoriteSeeder::class,
            UserSettingSeeder::class,
            UserPreferenceSeeder::class,
            DeviceSessionSeeder::class,
        ]);
    }
}
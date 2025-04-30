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
            // 1. User types must be seeded before users
            UserTypeSeeder::class,

            // 2. Restaurants first, then their locations
            RestaurantSeeder::class,
            RestaurantLocationSeeder::class,

            // 3. Users (admin + owner first) after restaurant_locations
            UserSeeder::class,

            // 4. Categories and tags
            CategorySeeder::class,
            TagSeeder::class,

            // 5. Pivot linking categories to branches
            CategoryLocationSeeder::class,

            // 6. Products and product pivot
            ProductSeeder::class,
            ProductLocationSeeder::class,

            // 7. Physical setup (after locations exist)
            SensorSeeder::class,
            TableSeeder::class,
            ChairSeeder::class,

            // 8. Chats/messages after users
            ChatSeeder::class,
            MessageSeeder::class,

            // 9. Orders and related review/favorites (need users/products/tables)
            OrderSeeder::class,
            ReviewSeeder::class,
            FavoriteSeeder::class,

            // 10. User personalization
            UserSettingSeeder::class,
            UserPreferenceSeeder::class,
            DeviceSessionSeeder::class,
        ]);

    }
}
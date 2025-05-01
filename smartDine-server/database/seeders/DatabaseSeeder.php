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
            // 1. Base system types
            UserTypeSeeder::class,

            // 2. Users (admin, owner, client, staff)
            UserSeeder::class,

            // 3. Restaurants and branches
            RestaurantSeeder::class,
            RestaurantLocationSeeder::class,

            // 4. Assign staff to branches (pivot)
            StaffLocationSeeder::class,

            // 5. Categories, products, and tags
            CategorySeeder::class,
            ProductSeeder::class,
            TagSeeder::class,
            ProductTagSeeder::class,

            // 6. Attach products & categories to branches
            LocationableSeeder::class,

            // 7. Physical setup (sensors, tables, chairs)
            SensorSeeder::class,
            TableSeeder::class,
            ChairSeeder::class,

            // 8. Orders, favorites, reviews
            OrderSeeder::class,
            FavoriteSeeder::class,
            ReviewSeeder::class,

            // 9. Product insights (analytics cache)
            ProductInsightsSeeder::class,

            // 10. Chats and messages
            ChatSeeder::class,
            MessageSeeder::class,

            // 11. Personalization and sessions
            UserSettingSeeder::class,
            UserPreferenceSeeder::class,
            DeviceSessionSeeder::class,
        ]);
    }
}

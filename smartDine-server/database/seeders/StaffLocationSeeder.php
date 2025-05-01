<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\RestaurantLocation;

class StaffLocationSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['waiter', 'chef', 'cashier']; // all staff use same app
        $staff = User::where('user_type_id', 3)->get();
        $locationIds = RestaurantLocation::pluck('id')->toArray();
        $used = [];

        foreach ($staff as $user) {
            $branches = rand(1, 2);
            $assigned = [];

            while (count($assigned) < $branches) {
                $locId = $locationIds[array_rand($locationIds)];
                $key = "$user->id-$locId";

                if (in_array($key, $used)) continue;
                $used[] = $key;
                $assigned[] = $locId;

                DB::table('staff_locations')->insert([
                    'user_id' => $user->id,
                    'restaurant_location_id' => $locId,
                    'role' => $roles[array_rand($roles)],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

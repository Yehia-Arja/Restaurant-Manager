<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    public function definition(): array
    {
        static $ownerIds = null;

        if (is_null($ownerIds)) {
            $ownerIds = User::where('user_type_id', 2)->pluck('id')->toArray(); // 2 = owner
        }

        return [
            'owner_id' => $this->faker->randomElement($ownerIds),
            'name' => $this->faker->company(),
            'file_name' => $this->faker->word() . '.jpg',
            'logo' => $this->faker->word() . '.jpg',
            'description' => $this->faker->optional()->paragraph(),
        ];
    }
}

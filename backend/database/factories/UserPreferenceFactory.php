<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserPreference>
 */
class UserPreferenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userIds = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
        }

        return [
            'user_id' => $userIds[array_rand($userIds)],
            'summary' => json_encode([
                'likes' => $this->faker->randomElements(['spicy', 'cheesy', 'grilled', 'sweet'], rand(1, 2)),
                'dislikes' => $this->faker->randomElements(['salty', 'sour', 'bitter'], rand(0, 2)),
                'favorite_dishes' => $this->faker->randomElements(range(1, 100), rand(0, 3))
            ])
        ];
    }
}

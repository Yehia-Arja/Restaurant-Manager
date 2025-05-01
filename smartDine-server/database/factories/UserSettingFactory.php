<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSetting>
 */
class UserSettingFactory extends Factory
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
            'user_id' => $this->faker->unique()->randomElement($userIds),
            'dark_mode' => $this->faker->boolean(50),
            'notifications' => $this->faker->boolean(80),
        ];
    }
}

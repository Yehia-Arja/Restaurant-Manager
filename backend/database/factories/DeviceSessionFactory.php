<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DeviceSession>
 */
class DeviceSessionFactory extends Factory
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
            'device_name' => $this->faker->userAgent(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->userAgent(),
            'last_used_at' => now()->subMinutes(rand(1, 10000)),
            'is_active' => $this->faker->boolean(80),
            'user_id' => $this->faker->randomElement($userIds),
        ];
    }
}

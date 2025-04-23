<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Chat;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $userIds = null;
        static $chatIds = null;

        if (is_null($userIds)) {
            $userIds = User::pluck('id')->toArray();
        }

        if (is_null($chatIds)) {
            $chatIds = Chat::pluck('id')->toArray();
        }

        return [
            'sender_type' => $this->faker->randomElement(['user', 'ai']),
            'content' => $this->faker->sentence(),
            'user_id' => $userIds[array_rand($userIds)],
            'chat_id' => $chatIds[array_rand($chatIds)],
        ];
    }
}
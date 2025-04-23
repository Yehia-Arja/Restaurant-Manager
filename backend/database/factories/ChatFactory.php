<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Chat>
 */
class ChatFactory extends Factory
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
        ];
    }
}

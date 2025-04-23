<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\UserType;
use App\Models\RestaurantLocation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $locationIds = null;

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'google_id' => null,
            'provider' => null,
            'phone_number' => $this->faker->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => $this->faker->date(),
            'remember_token' => Str::random(10),
            'user_type_id' => $this->faker->numberBetween(3, 4), // Only Client (3) or Waiter (4)
            'restaurant_location_id' => $this->faker->boolean(70) ? $locationIds[array_rand($locationIds)] : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}

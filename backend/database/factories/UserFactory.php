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
        static $restaurantIds = null;

        if (is_null($locationIds)) {
            $locationIds = RestaurantLocation::pluck('id')->toArray();
        }

        if (is_null($restaurantIds)) {
            // collect unique restaurant_id values from locations
            $restaurantIds = RestaurantLocation::pluck('restaurant_id')->unique()->toArray();
        }

        // Decide user type (2 = Owner, 3 = Client, 4 = Waiter)
        $userType = $this->faker->numberBetween(2, 4);

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'google_id' => null,
            'provider' => null,
            'phone_number' => $this->faker->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => $this->faker->date(),
            'remember_token' => Str::random(10),

            'user_type_id' => $userType,

            // Only Owners (type 2) get a restaurant_id
            'restaurant_id' => $userType === 2 ? $this->faker->randomElement($restaurantIds) : null,

            // Only Waiters (type 4) get a branch
            'restaurant_location_id' => $userType === 4 ? $this->faker->randomElement($locationIds) : null,
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

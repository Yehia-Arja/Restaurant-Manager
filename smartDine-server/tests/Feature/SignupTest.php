<?php

namespace Tests\Feature;

use Database\Seeders\UserTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SignupTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_user_can_signup_and_get_token_and_user_type_id(): void
    {
        $this->seed(UserTypeSeeder::class);

        $email = $this->faker->unique()->safeEmail;
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;

        $response = $this->postJson('/api/v0.1/guest/signup', [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'user_type_id',
                'access_token',
            ]
        ]);
        $this->assertEquals(4, $response->json('data.user_type_id'));
        $this->assertIsString($response->json('data.access_token'));
    }
}

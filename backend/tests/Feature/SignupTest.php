<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SignupTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Make sure user_type_id = 4 (“client”) exists
        $this->seed(UserTypeSeeder::class);
    }

    /** @test */
    public function signup_creates_user_and_returns_user_and_token()
    {
        $payload = [
            'first_name'            => 'Yehia',
            'last_name'             => 'Arja',
            'email'                 => 'reyna55s@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ];

        $response = $this->postJson('/api/v0.1/guest/signup', $payload);

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Signup successful',
                 ])
                 ->assertJsonStructure([
                     'success',
                     'message',
                     'data' => [
                         'user' => [
                             'id',
                             'first_name',
                             'last_name',
                             'user_type_id',
                             'restaurant_id',
                             'restaurant_location_id',
                             'phone_number',
                             'date_of_birth',
                             'google_id',
                             'provider',
                             'email',
                         ],
                         'access_token',
                     ],
                 ]);

        $this->assertDatabaseHas('users', [
            'email'        => 'reyna55s@example.com',
            'first_name'   => 'Yehia',
            'last_name'    => 'Arja',
            'user_type_id' => 4,
        ]);
    }

    /** @test */
    public function signup_with_existing_email_returns_validation_error()
    {
        // Arrange: existing user
        User::factory()->create([
            'email'        => 'reyna55s@example.com',
            'user_type_id' => 4,
        ]);

        $response = $this->postJson('/api/v0.1/guest/signup', [
            'first_name'            => 'Yehia',
            'last_name'             => 'Arja',
            'email'                 => 'reyna55s@example.com',
            'password'              => 'secret123',
            'password_confirmation' => 'secret123',
        ]);

        // Assert: 422 Unprocessable Entity
        $response->assertStatus(422)
                 // Top‐level keys: message and errors
                 ->assertJsonStructure([
                     'message',
                     'errors' => [
                         'email'
                     ],
                 ])
                 // And the message matches what your validator returns
                 ->assertJson([
                     'message' => 'Email already exists',
                 ]);
    }
}

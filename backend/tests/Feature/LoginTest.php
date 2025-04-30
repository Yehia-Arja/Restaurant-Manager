<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed user types so user_type_id = 4 (“client”) exists
        $this->seed(UserTypeSeeder::class);
    }

    /** @test */
    public function login_with_valid_credentials_returns_user_and_token()
    {
        // Arrange: create a client user
        User::factory()->create([
            'first_name'               => 'Joe',
            'last_name'                => 'Doe',
            'email'                    => 'joe@example.test',
            'password'                 => bcrypt('mypassword'),
            'user_type_id'             => 4,
            'restaurant_id'            => null,
            'restaurant_location_id'   => null,
        ]);

        // Act: call your versioned login endpoint
        $response = $this->postJson('/api/v0.1/guest/login', [
            'email'    => 'joe@example.test',
            'password' => 'mypassword',
        ]);

        // Assert: 200 OK, correct flags, and full user+token structure
        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'message' => 'Login successful',
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
    }

    /** @test */
    public function login_with_invalid_credentials_returns_bad_request()
    {
        // Arrange: create a user with a known password
        User::factory()->create([
            'first_name'   => 'Joe',
            'last_name'    => 'Doe',
            'email'        => 'joe2@example.test',
            'password'     => bcrypt('rightpass'),
            'user_type_id' => 4,
        ]);

        // Act: attempt login with wrong password
        $response = $this->postJson('/api/v0.1/guest/login', [
            'email'    => 'joe2@example.test',
            'password' => 'wrongpass',
        ]);

        // Assert: HTTP 400 and simple error envelope
        $response->assertStatus(400)
                 ->assertJson([
                     'success' => false,
                 ])
                 ->assertJsonStructure([
                     'success',
                     'message',
                 ]);
    }
}

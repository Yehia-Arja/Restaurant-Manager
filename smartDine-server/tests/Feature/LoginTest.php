<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserTypeSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_and_get_token_and_user_type_id(): void
    {
        // Seed required FK data (user_types)
        $this->seed(UserTypeSeeder::class);

        // Create user with valid user_type_id (e.g., 4 = client)
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'user_type_id' => 4,
        ]);

        // Send login request
        $response = $this->postJson('/api/v0.1/guest/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        // Validate response
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

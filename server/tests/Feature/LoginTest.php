<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        // Create a test user
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        // Attempt login
        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@golfspot.io',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(200);
        $this->assertArrayHasKey('access_token', $response->json());
        $this->assertArrayHasKey('user', $response->json());
    }

    public function test_user_cannot_login_with_invalid_email()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@golfspot.io',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(401);
    }

    public function test_user_cannot_login_with_invalid_password()
    {
        // Create a test user
        User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@golfspot.io',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_validation_requires_email_and_password()
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_validation_requires_valid_email_format()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email']);
    }

    public function test_login_returns_user_data()
    {
        // Create a test user with profile data
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'email_verified_at' => now(),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'email' => 'test@golfspot.io',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_in',
            'user' => [
                'id',
                'email',
                'first_name',
                'last_name',
                'email_verified_at',
                'created_at',
                'updated_at'
            ]
        ]);

        $userData = $response->json('user');
        $this->assertEquals('test@golfspot.io', $userData['email']);
        $this->assertEquals('Test', $userData['first_name']);
        $this->assertEquals('User', $userData['last_name']);
    }
}

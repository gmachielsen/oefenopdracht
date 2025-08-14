<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends TestCase
{
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

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in',
                    'user' => [
                        'id',
                        'email',
                        'first_name',
                        'last_name',
                        'birth_date',
                        'profile_photo',
                        'email_verified_at',
                        'created_at',
                        'updated_at'
                    ]
                ]);

        $this->assertArrayHasKey('access_token', $response->json());
    }

    public function test_user_cannot_login_with_invalid_email()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'nonexistent@golfspot.io',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(401)
                ->assertJson([
                    'error' => 'Invalid credentials'
                ]);
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

        $response->assertStatus(401)
                ->assertJson([
                    'error' => 'Invalid credentials'
                ]);
    }

    public function test_login_validation_requires_email_and_password()
    {
        $response = $this->postJson('/api/auth/login', []);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_validation_requires_valid_email_format()
    {
        $response = $this->postJson('/api/auth/login', [
            'email' => 'invalid-email',
            'password' => 'wachtwoord123',
        ]);

        $response->assertStatus(422)
                ->assertJsonValidationErrors(['email']);
    }

    public function test_authenticated_user_can_logout()
    {
        // Create and authenticate user
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/logout');

        $response->assertStatus(200)
                ->assertJson([
                    'message' => 'Successfully logged out'
                ]);
    }

    public function test_unauthenticated_user_cannot_logout()
    {
        $response = $this->postJson('/api/auth/logout');

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_authenticated_user_can_refresh_token()
    {
        // Create and authenticate user
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/auth/refresh');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'access_token',
                    'token_type',
                    'expires_in'
                ]);
    }

    public function test_unauthenticated_user_cannot_refresh_token()
    {
        $response = $this->postJson('/api/auth/refresh');

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_authenticated_user_can_get_profile()
    {
        // Create user with profile data
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'first_name' => 'Test',
            'last_name' => 'User',
            'birth_date' => '1990-01-01',
            'email_verified_at' => now(),
        ]);

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/auth/me');

        $response->assertStatus(200)
                ->assertJson([
                    'id' => $user->id,
                    'email' => 'test@golfspot.io',
                    'first_name' => 'Test',
                    'last_name' => 'User',
                ]);
        
        // Check birth_date separately as it includes time
        $userData = $response->json();
        $this->assertStringStartsWith('1990-01-01', $userData['birth_date']);
    }

    public function test_unauthenticated_user_cannot_get_profile()
    {
        $response = $this->getJson('/api/auth/me');

        $response->assertStatus(401)
                ->assertJson([
                    'message' => 'Unauthenticated.'
                ]);
    }

    public function test_jwt_token_can_access_protected_route()
    {
        // Create user
        $user = User::create([
            'email' => 'test@golfspot.io',
            'password' => Hash::make('wachtwoord123'),
            'email_verified_at' => now(),
        ]);

        // Create a token
        $token = JWTAuth::fromUser($user);
        
        // Verify token can access protected route
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->getJson('/api/auth/me');

        $response->assertStatus(200);
        $this->assertArrayHasKey('id', $response->json());
        $this->assertArrayHasKey('email', $response->json());
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'test@golfspot.io'],
            [
                'name' => 'Test User',
                'email' => 'test@golfspot.io',
                'password' => Hash::make('wachtwoord123'),
                'email_verified_at' => now(),
            ]
        );
    }
}

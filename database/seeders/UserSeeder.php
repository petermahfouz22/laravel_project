<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create an admin user only if it doesn't exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Create a test employer if it doesn't exist
        User::firstOrCreate(
            ['email' => 'employer@example.com'],
            [
                'name' => 'Test Employer',
                'password' => Hash::make('password'),
                'role' => 'employer',
            ]
        );
        
        // Create a test candidate if it doesn't exist
        User::firstOrCreate(
            ['email' => 'candidate@example.com'],
            [
                'name' => 'Test Candidate',
                'password' => Hash::make('password'),
                'role' => 'candidate',
            ]
        );

        // Only create random users if needed (optional check)
        if (User::where('role', 'employer')->count() < 10) {
            User::factory()->count(10)->employer()->create();
        }

        if (User::where('role', 'candidate')->count() < 20) {
            User::factory()->count(20)->candidate()->create();
        }
    }
}
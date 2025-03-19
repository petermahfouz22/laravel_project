<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        Profile::factory()->create([
            'user_id' => $admin->id,
        ]);
        
        // Create demo employer user
        $employer = User::factory()->create([
            'name' => 'Demo Employer',
            'email' => 'employer@example.com',
            'password' => Hash::make('password'),
            'role' => 'employer',
        ]);
        
        Profile::factory()->create([
            'user_id' => $employer->id,
        ]);
        
        // Create demo candidate user
        $candidate = User::factory()->create([
            'name' => 'Demo Candidate',
            'email' => 'candidate@example.com',
            'password' => Hash::make('password'),
            'role' => 'candidate',
        ]);
        
        Profile::factory()->create([
            'user_id' => $candidate->id,
        ]);
        
        // Create 50 random users (mix of employers and candidates) with profiles
        User::factory()
            ->count(20)
            ->employer()
            ->has(Profile::factory())
            ->create();
            
        User::factory()
            ->count(30)
            ->candidate()
            ->has(Profile::factory())
            ->create();
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Predefined users with different roles
        $users = [
            [
                'name' => 'Admin User',
                'email' => 'admin@jobportal.com',
                'password' => Hash::make('JobPortal2024!'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'John Employer',
                'email' => 'john.employer@jobportal.com',
                'password' => Hash::make('JobPortal2024!'),
                'role' => 'employer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sarah Candidate',
                'email' => 'sarah.candidate@jobportal.com',
                'password' => Hash::make('JobPortal2024!'),
                'role' => 'candidate',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Mike Recruiter',
                'email' => 'mike.employer@jobportal.com',
                'password' => Hash::make('JobPortal2024!'),
                'role' => 'employer',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Emily Job Seeker',
                'email' => 'emily.candidate@jobportal.com',
                'password' => Hash::make('JobPortal2024!'),
                'role' => 'candidate',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        // Insert users
        DB::table('users')->insert($users);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the seeded users
        DB::table('users')
            ->whereIn('email', [
                'admin@jobportal.com', 
                'john.employer@jobportal.com', 
                'sarah.candidate@jobportal.com',
                'mike.employer@jobportal.com',
                'emily.candidate@jobportal.com'
            ])
            ->delete();
    }
};
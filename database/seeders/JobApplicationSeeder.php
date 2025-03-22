<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Job;
use App\Models\Application;
use App\Models\User;
use App\Models\Company;

class JobApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if we have employers first
        $employerCount = User::where('role', 'employer')->count();
        
        if ($employerCount < 5) {
            // Create some employer users if none exist
            User::factory()->count(5)->create([
                'role' => 'employer',
            ]);
        }
        
        // Check if we have candidates
        $candidateCount = User::where('role', 'candidate')->count();
        
        if ($candidateCount < 10) {
            // Create some candidate users if none exist
            User::factory()->count(10)->create([
                'role' => 'candidate',
            ]);
        }
        
        // Create companies for employers
        $companyCount = Company::count();
        if ($companyCount < 5) {
            // Get employer IDs
            $employers = User::where('role', 'employer')->pluck('id')->toArray();
            
            // Create a company for each employer
            foreach ($employers as $employerId) {
                Company::factory()->create([
                    'user_id' => $employerId
                ]);
            }
            
            $this->command->info('Created companies for employers!');
        }
        
        // Create 20 jobs
        Job::factory()->count(20)->create()->each(function ($job) {
            // For each job, create 1-5 applications
            $applicationCount = rand(1, 5);
            Application::factory()->count($applicationCount)->create([
                'job_id' => $job->id,
            ]);
        });
        
        $this->command->info('Created 20 jobs with applications!');
    }
}
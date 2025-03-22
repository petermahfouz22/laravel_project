<?php

namespace Database\Seeders;

use App\Models\FeaturedJob;
use App\Models\Job;
use Illuminate\Database\Seeder;

class FeaturedJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active and approved jobs
        $jobs = Job::where('is_active', true)
                   ->where('is_approved', true)
                   ->get();
        
        // Select 10 random jobs to be featured
        $featuredJobs = $jobs->random(min(10, count($jobs)));
        
        // For each featured job, create a featured job entry
        foreach ($featuredJobs as $index => $job) {
            $startDate = fake()->dateTimeBetween('-1 month', '+1 week');
            $endDate = fake()->dateTimeBetween($startDate, '+3 months');
            
            FeaturedJob::create([
                'job_id' => $job->id,
                'priority' => $index + 1, // Priority from 1 to 10
                'start_date' => $startDate,
                'end_date' => $endDate,
            ]);
        }
    }
}
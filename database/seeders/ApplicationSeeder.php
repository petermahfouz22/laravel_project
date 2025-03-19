<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
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
                   
        // Get all candidates
        $candidates = User::where('role', 'candidate')->get();
        
        // For each job, create 0-10 applications from random candidates
        foreach ($jobs as $job) {
            $numApplications = rand(0, 10);
            
            // Select random candidates for this job
            $jobCandidates = $candidates->random(min($numApplications, count($candidates)));
            
            foreach ($jobCandidates as $candidate) {
                $statuses = ['pending', 'accepted', 'rejected'];
                
                Application::create([
                    'job_id' => $job->id,
                    'candidate_id' => $candidate->id,
                    'resume' => 'resumes/candidate-resume-' . fake()->randomNumber(5) . '.pdf',
                    'cover_letter' => fake()->paragraphs(3, true),
                    'status' => fake()->randomElement($statuses),
                    'notes' => fake()->boolean(60) ? fake()->paragraph() : null,
                ]);
            }
            
            // Update the applications count for this job
            $job->applications_count = $numApplications;
            $job->save();
        }
    }
}
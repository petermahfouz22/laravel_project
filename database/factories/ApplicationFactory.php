<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // Get candidate IDs from users with candidate role
        $candidates = User::where('role', 'candidate')->pluck('id')->toArray();
        
        // If no candidates exist, use any user ID except employers
        if (empty($candidates)) {
            $candidates = User::where('role', '!=', 'employer')->pluck('id')->toArray();
            
            // If still empty, use any user ID
            if (empty($candidates)) {
                $candidates = User::pluck('id')->toArray();
            }
        }

        // Get active job IDs
        $jobs = Job::where('is_active', true)
                   ->where('application_deadline', '>=', now())
                   ->pluck('id')
                   ->toArray();
        
        // If no active jobs, use any job
        if (empty($jobs)) {
            $jobs = Job::pluck('id')->toArray();
        }

        // Application statuses
        $statuses = ['pending', 'reviewing', 'shortlisted', 'rejected', 'hired'];
        
        return [
            'job_id' => $this->faker->randomElement($jobs),
            'candidate_id' => $this->faker->randomElement($candidates),
            'cover_letter' => $this->faker->paragraphs(2, true),
            'resume_path' => 'resumes/default_resume.pdf', // Default resume path
            'status' => $this->faker->randomElement($statuses),
            'created_at' => $this->faker->dateTimeBetween('-14 days', 'now'),
            'updated_at' => now(),
        ];
    }
}
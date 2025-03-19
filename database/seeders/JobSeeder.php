<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\Technology;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all companies
        $companies = Company::all();
        $categories = JobCategory::all();
        $technologies = Technology::all();
        
        // For each company, create 1-5 jobs
        foreach ($companies as $company) {
            $numJobs = rand(1, 5);
            
            for ($i = 0; $i < $numJobs; $i++) {
                $title = fake()->jobTitle();
                $workTypes = ['remote', 'onsite', 'hybrid'];
                $salaryMin = fake()->numberBetween(30000, 80000);
                $salaryMax = fake()->numberBetween($salaryMin, $salaryMin + 50000);
                
                $job = Job::create([
                    'employer_id' => $company->user_id,
                    'company_id' => $company->id,
                    'category_id' => $categories->random()->id,
                    'title' => $title,
                    'slug' => Str::slug($title) . '-' . Str::random(5),
                    'description' => fake()->paragraphs(3, true),
                    'responsibilities' => fake()->paragraphs(2, true),
                    'requirements' => fake()->paragraphs(2, true),
                    'benefits' => fake()->paragraphs(1, true),
                    'location' => fake()->city() . ', ' . fake()->country(),
                    'work_type' => fake()->randomElement($workTypes),
                    'salary_min' => $salaryMin,
                    'salary_max' => $salaryMax,
                    'application_deadline' => fake()->dateTimeBetween('+1 week', '+3 months'),
                    'is_active' => fake()->boolean(80), // 80% chance of being active
                    'is_approved' => fake()->boolean(70), // 70% chance of being approved
                    'views_count' => fake()->numberBetween(0, 500),
                    'applications_count' => 0, // Will be updated as applications are created
                    'salary_range' => '$' . ($salaryMin/1000) . 'k - $' . ($salaryMax/1000) . 'k',
                    'employment_type' => fake()->randomElement(['Full-time', 'Part-time', 'Contract', 'Temporary', 'Internship']),
                ]);
                
                // Attach 2-5 random technologies to each job
                $randomTechnologies = $technologies->random(rand(2, 5))->pluck('id')->toArray();
                $job->technologies()->attach($randomTechnologies);
            }
        }
    }
}
<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Job;
use App\Models\JobCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        $title = $this->faker->jobTitle();
        $workTypes = ['remote', 'onsite', 'hybrid'];
        $salaryMin = $this->faker->numberBetween(30000, 80000);
        $salaryMax = $this->faker->numberBetween($salaryMin, $salaryMin + 50000);

        return [
            'employer_id' => User::factory()->employer(),
            'company_id' => Company::factory(),
            'category_id' => JobCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(5),
            'description' => $this->faker->paragraphs(3, true),
            'responsibilities' => $this->faker->paragraphs(2, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'benefits' => $this->faker->paragraphs(1, true),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'work_type' => $this->faker->randomElement($workTypes),
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'application_deadline' => $this->faker->dateTimeBetween('+1 week', '+3 months'),
            'is_active' => $this->faker->boolean(80), // 80% chance of being active
            'is_approved' => $this->faker->boolean(70), // 70% chance of being approved
            'views_count' => $this->faker->numberBetween(0, 500),
            'applications_count' => $this->faker->numberBetween(0, 50),
            'salary_range' => '$' . ($salaryMin/1000) . 'k - $' . ($salaryMax/1000) . 'k',
            'employment_type' => $this->faker->randomElement(['Full-time', 'Part-time', 'Contract', 'Temporary', 'Internship']),
        ];
    }
}

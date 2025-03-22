<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\Job;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    protected $model = Job::class;

    public function definition()
    {
        $title = $this->faker->randomElement([
            'Senior Laravel Developer', 'Frontend Engineer', 'Full Stack PHP Developer',
            'Web Application Developer', 'DevOps Engineer', 'UI/UX Designer',
            'System Administrator', 'Project Manager', 'QA Engineer',
            'Database Administrator', 'Mobile Developer', 'Backend Developer'
        ]);
        
        $workTypes = ['remote', 'onsite', 'hybrid'];
                $workType = $this->faker->randomElement($workTypes);
        
        $locations = [
            'New York, NY', 'San Francisco, CA', 'Austin, TX', 
            'Chicago, IL', 'Seattle, WA', 'Boston, MA',
            'Remote', 'London, UK', 'Toronto, Canada'
        ];
        
        $salaryMin = $this->faker->numberBetween(50000, 120000);
        $salaryMax = $salaryMin + $this->faker->numberBetween(10000, 80000);
        
        // Generate the description with more structure
        $description = "We are looking for a talented " . $title . " to join our dynamic team. ";
        $description .= "The ideal candidate will have experience with " . $this->faker->randomElement(['Laravel', 'PHP', 'Vue.js', 'React', 'AWS']) . ". ";
        $description .= "This is a " . $workType . " position that offers competitive compensation and benefits.";
        
        // Generate structured responsibilities
        $responsibilities = "## Key Responsibilities\n\n";
        $responsibilities .= "- Design and implement " . $this->faker->randomElement(['web applications', 'APIs', 'database solutions', 'user interfaces', 'system architecture']) . "\n";
        $responsibilities .= "- Collaborate with " . $this->faker->randomElement(['product managers', 'designers', 'other developers', 'stakeholders', 'QA team']) . "\n";
        $responsibilities .= "- Maintain and optimize " . $this->faker->randomElement(['existing codebase', 'database performance', 'CI/CD pipelines', 'application security', 'cloud infrastructure']) . "\n";
        $responsibilities .= "- Participate in " . $this->faker->randomElement(['code reviews', 'sprint planning', 'agile ceremonies', 'technical discussions', 'product demos']) . "\n";
        $responsibilities .= "- " . $this->faker->randomElement([
            'Troubleshoot and debug issues in production environments',
            'Implement automated testing for new features',
            'Document technical specifications and solutions',
            'Mentor junior developers',
            'Research and evaluate new technologies'
        ]);
        
        // Generate structured requirements
        $requirements = "## Requirements\n\n";
        $requirements .= "- " . $this->faker->numberBetween(2, 8) . "+ years of experience in " . $this->faker->randomElement(['web development', 'software engineering', 'PHP development', 'frontend development', 'backend development']) . "\n";
        $requirements .= "- Proficiency in " . $this->faker->randomElement(['Laravel', 'PHP', 'JavaScript', 'HTML/CSS', 'SQL']) . "\n";
        $requirements .= "- Experience with " . $this->faker->randomElement(['Vue.js', 'React', 'Angular', 'jQuery', 'REST APIs']) . "\n";
        $requirements .= "- Knowledge of " . $this->faker->randomElement(['MySQL', 'PostgreSQL', 'MongoDB', 'Redis', 'ElasticSearch']) . "\n";
        $requirements .= "- " . $this->faker->randomElement([
            'Strong problem-solving skills and attention to detail',
            'Ability to work independently and in a team environment',
            'Excellent communication skills, both written and verbal',
            'Experience with Agile development methodologies',
            'Bachelor\'s degree in Computer Science or equivalent experience'
        ]);
        
        // Generate structured benefits
        $benefits = "## Benefits\n\n";
        $benefits .= "- Competitive salary range: $" . number_format($salaryMin) . " - $" . number_format($salaryMax) . "\n";
        $benefits .= "- " . $this->faker->randomElement(['Health, dental, and vision insurance', 'Comprehensive medical coverage', 'Premium healthcare package']) . "\n";
        $benefits .= "- " . $this->faker->randomElement(['401(k) matching', 'Retirement savings plan', 'Pension contribution']) . "\n";
        $benefits .= "- " . $this->faker->randomElement(['Flexible working hours', 'Remote work options', 'Work-life balance focus']) . "\n";
        $benefits .= "- " . $this->faker->randomElement([
            'Professional development opportunities',
            'Paid time off and holidays',
            'Stock options',
            'Company retreats and team building events',
            'Wellness programs and gym membership'
        ]);
        
        return [
            'employer_id' => User::where('role', 'employer')->inRandomOrder()->first()->id ?? User::factory()->create(['role' => 'employer'])->id,
            'company_id' => Company::inRandomOrder()->first()->id ?? Company::factory()->create()->id,
            'category_id' => JobCategory::inRandomOrder()->first()->id ?? JobCategory::factory()->create()->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(8),
            'description' => $description,
            'responsibilities' => $responsibilities,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'location' => $this->faker->randomElement($locations),
            'work_type' => $workType,
            'salary_min' => $salaryMin,
            'salary_max' => $salaryMax,
            'application_deadline' => $this->faker->dateTimeBetween('+1 week', '+2 months'),
            'is_active' => $this->faker->boolean(90),
            'is_approved' => $this->faker->boolean(80),
        ];
    }
}
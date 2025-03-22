<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobCategoryFactory extends Factory
{
    protected $model = JobCategory::class;

    public function definition()
    {
        $categories = [
            'Web Development', 'Mobile Development', 'UI/UX Design',
            'Data Science', 'DevOps', 'Project Management',
            'QA & Testing', 'Security', 'Network Administration',
            'Database Administration', 'Frontend Development', 'Backend Development'
        ];
        
        $name = $this->faker->unique()->randomElement($categories);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => $this->faker->sentence(),
        ];
    }
}
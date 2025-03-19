<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class JobCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined job categories
        $categories = [
            'Software Development',
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Data Science',
            'DevOps',
            'Quality Assurance',
            'Product Management',
            'Project Management',
            'Marketing',
            'Sales',
            'Customer Support',
            'Human Resources',
            'Finance',
            'Administration',
        ];
        
        foreach ($categories as $category) {
            JobCategory::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => fake()->paragraph(),
            ]);
        }
        
        // Create 5 additional random categories
        JobCategory::factory()->count(5)->create();
    }
}
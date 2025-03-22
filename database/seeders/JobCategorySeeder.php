<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Web Development', 'Mobile Development', 'UI/UX Design',
            'Data Science', 'DevOps', 'Project Management',
            'QA & Testing', 'Security', 'Network Administration',
            'Database Administration', 'Frontend Development', 'Backend Development'
        ];
        
        foreach ($categories as $category) {
            JobCategory::create([
                'name' => $category,
                'slug' => \Illuminate\Support\Str::slug($category),
                'description' => fake()->sentence(),
            ]);
        }
    }
}

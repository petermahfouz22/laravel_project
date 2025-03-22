<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Data Science',
            'DevOps',
            'Cloud Computing',
            'Artificial Intelligence',
            'Digital Marketing',
        ];

        foreach ($categories as $category) {
            JobCategory::create([
                'name' => $category,
                'slug' => \Str::slug($category),
            ]);
        }
    }
}

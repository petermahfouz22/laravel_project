<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            // If you need users first for employer_id
            UserSeeder::class,
            CompanySeeder::class,
            JobCategorySeeder::class,
            TechnologySeeder::class,
            JobSeeder::class,
            ApplicationSeeder::class,
            ResumeSeeder::class,
            InterviewSeeder::class,
            FeaturedJobSeeder::class,
        ]);
    }
}
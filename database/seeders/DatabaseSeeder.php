<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            JobCategorySeeder::class,
            TechnologySeeder::class,
            CompanySeeder::class,
            JobSeeder::class,
            ApplicationSeeder::class,
            ResumeSeeder::class,
            InterviewSeeder::class,
            FeaturedJobSeeder::class,
        ]);
    }
}
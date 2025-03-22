<?php
namespace Database\Seeders;

use App\Models\Job;
use App\Models\Technology;
use Illuminate\Database\Seeder;

class JobSeeder extends Seeder
{
    public function run()
    {
        // Create 50 jobs
        Job::factory()
            ->count(50)
            ->create()
            ->each(function ($job) {
                // Attach 3-6 random technologies to each job
                $technologies = Technology::inRandomOrder()->take(rand(3, 6))->pluck('id');
                $job->technologies()->attach($technologies);
            });
    }
}
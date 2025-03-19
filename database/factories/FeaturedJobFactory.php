<?php

namespace Database\Factories;

use App\Models\FeaturedJob;
use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeaturedJobFactory extends Factory
{
    protected $model = FeaturedJob::class;

    public function definition()
    {
        $startDate = $this->faker->dateTimeBetween('-1 month', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+3 months');
        
        return [
            'job_id' => Job::factory(),
            'priority' => $this->faker->numberBetween(1, 10),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
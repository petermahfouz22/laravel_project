<?php

namespace Database\Factories;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ResumeFactory extends Factory
{
    protected $model = Resume::class;

    public function definition()
    {
        return [
            'candidate_id' => User::factory()->candidate(),
            'title' => $this->faker->words(3, true) . ' Resume',
            'file_path' => 'resumes/' . $this->faker->uuid() . '.pdf',
            'is_default' => $this->faker->boolean(70), // 70% chance of being default
        ];
    }
}
<?php

namespace Database\Factories;

use App\Models\Application;
use App\Models\Interview;
use Illuminate\Database\Eloquent\Factories\Factory;

class InterviewFactory extends Factory
{
    protected $model = Interview::class;

    public function definition()
    {
        $isOnline = $this->faker->boolean(70); // 70% chance of being online
        $isCompleted = $this->faker->boolean(50); // 50% chance of being completed
        
        return [
            'application_id' => Application::factory(),
            'scheduled_at' => $this->faker->dateTimeBetween('+1 day', '+2 weeks'),
            'duration' => $this->faker->randomElement([30, 45, 60, 90, 120]), // Duration in minutes
            'location' => $isOnline ? null : $this->faker->address(),
            'is_online' => $isOnline,
            'meeting_link' => $isOnline ? 'https://meet.zoom.us/' . $this->faker->uuid() : null,
            'notes' => $this->faker->paragraph(),
            'completed' => $isCompleted,
            'outcome_notes' => $isCompleted ? $this->faker->paragraph() : null,
        ];
    }
}
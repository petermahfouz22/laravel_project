<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\Interview;
use Illuminate\Database\Seeder;

class InterviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all applications that were accepted
        $applications = Application::where('status', 'accepted')->get();
        
        // For each accepted application, create an interview
        foreach ($applications as $application) {
            $isOnline = fake()->boolean(70); // 70% chance of being online
            $isCompleted = fake()->boolean(50); // 50% chance of being completed
            
            Interview::create([
                'application_id' => $application->id,
                'scheduled_at' => fake()->dateTimeBetween('-1 week', '+2 weeks'),
                'duration' => fake()->randomElement([30, 45, 60, 90, 120]), // Duration in minutes
                'location' => $isOnline ? null : fake()->address(),
                'is_online' => $isOnline,
                'meeting_link' => $isOnline ? 'https://meet.zoom.us/' . fake()->uuid() : null,
                'notes' => fake()->paragraph(),
                'completed' => $isCompleted,
                'outcome_notes' => $isCompleted ? fake()->paragraph() : null,
            ]);
        }
    }
}
<?php

namespace Database\Factories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnologyFactory extends Factory
{
    protected $model = Technology::class;

    public function definition()
    {
        // Ensure we have realistic technology names
        $technologies = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Angular', 
            'Node.js', 'Python', 'Django', 'Flask', 'Ruby', 'Ruby on Rails',
            'Java', 'Spring', 'C#', '.NET', 'SQL', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Redis', 'Docker', 'Kubernetes', 'AWS', 'Azure',
            'Google Cloud', 'Swift', 'Kotlin', 'Flutter', 'React Native'
        ];
        
        // Get a random technology that hasn't been used yet
        static $usedTechnologies = [];
        $technology = $this->faker->unique()->randomElement($technologies);
        
        return [
            'name' => $technology,
        ];
    }
}
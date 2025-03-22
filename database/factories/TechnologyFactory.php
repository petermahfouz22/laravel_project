<?php

namespace Database\Factories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class TechnologyFactory extends Factory
{
    protected $model = Technology::class;

    public function definition()
    {
        $technologies = [
            'PHP', 'Laravel', 'Vue.js', 'React', 'Angular',
            'JavaScript', 'Python', 'Django', 'Ruby on Rails',
            'Node.js', 'Express.js', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Redis', 'Docker', 'AWS', 'Azure',
            'Git', 'CI/CD', 'RESTful APIs', 'GraphQL'
        ];
        
        $name = $this->faker->unique()->randomElement($technologies);
        
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
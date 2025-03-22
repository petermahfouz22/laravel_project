<?php


namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    public function run()
    {
        $technologies = [
            'PHP', 'Laravel', 'Vue.js', 'React', 'Angular',
            'JavaScript', 'Python', 'Django', 'Ruby on Rails',
            'Node.js', 'Express.js', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Redis', 'Docker', 'AWS', 'Azure',
            'Git', 'CI/CD', 'RESTful APIs', 'GraphQL'
        ];
        
        foreach ($technologies as $tech) {
            Technology::create([
                'name' => $tech,
                'slug' => \Illuminate\Support\Str::slug($tech),
            ]);
        }
    }
}
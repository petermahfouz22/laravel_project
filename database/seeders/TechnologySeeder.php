<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create predefined technologies
        $technologies = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Angular', 
            'Node.js', 'Python', 'Django', 'Flask', 'Ruby', 'Ruby on Rails',
            'Java', 'Spring', 'C#', '.NET', 'SQL', 'MySQL', 'PostgreSQL',
            'MongoDB', 'Redis', 'Docker', 'Kubernetes', 'AWS', 'Azure',
            'Google Cloud', 'Swift', 'Kotlin', 'Flutter', 'React Native'
        ];
        
        foreach ($technologies as $tech) {
            Technology::create([
                'name' => $tech
            ]);
        }
    }
}
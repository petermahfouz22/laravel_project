<?php

namespace Database\Seeders;

use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Seeder;

class ResumeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all candidates
        $candidates = User::where('role', 'candidate')->get();
        
        // For each candidate, create 1-3 resumes
        foreach ($candidates as $candidate) {
            $numResumes = rand(1, 3);
            
            // First resume is always the default
            Resume::create([
                'candidate_id' => $candidate->id,
                'title' => 'Main Resume',
                'file_path' => 'resumes/candidate-' . $candidate->id . '-main.pdf',
                'is_default' => true,
            ]);
            
            // Create additional resumes if needed
            for ($i = 1; $i < $numResumes; $i++) {
                Resume::create([
                    'candidate_id' => $candidate->id,
                    'title' => fake()->words(3, true) . ' Resume',
                    'file_path' => 'resumes/candidate-' . $candidate->id . '-' . $i . '.pdf',
                    'is_default' => false,
                ]);
            }
        }
    }
}
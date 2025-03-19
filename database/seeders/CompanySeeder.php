<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all employer users
        $employers = User::where('role', 'employer')->get();
        
        // Create 1-2 companies for each employer
        foreach ($employers as $employer) {
            $numCompanies = rand(1, 2);
            
            for ($i = 0; $i < $numCompanies; $i++) {
                Company::factory()->create([
                    'user_id' => $employer->id,
                ]);
            }
        }
    }
}
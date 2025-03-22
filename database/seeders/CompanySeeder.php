<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 companies linked to random employers
        Company::factory()
            ->count(10)
            ->create([
                'user_id' => fn() => \App\Models\User::where('role', 'employer')->inRandomOrder()->first()->id,
            ]);
    }
}
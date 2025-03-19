<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        $industries = [
            'Technology', 'Finance', 'Healthcare', 'Education', 
            'Manufacturing', 'Retail', 'Hospitality', 'Media',
            'Transportation', 'Construction', 'Energy', 'Agriculture'
        ];
        
        $sizes = ['1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'];
        
        return [
            'user_id' => User::factory()->employer(),
            'name' => $this->faker->company(),
            'description' => $this->faker->paragraphs(3, true),
            'logo' => 'company-logos/default.jpg',
            'website' => 'https://www.' . $this->faker->domainName(),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'industry' => $this->faker->randomElement($industries),
            'size' => $this->faker->randomElement($sizes),
            'founded_year' => $this->faker->numberBetween(1980, 2023),
        ];
    }
}
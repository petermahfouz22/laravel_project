<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition()
    {
        $name = $this->faker->company();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'logo' => 'companies/default.png', // Default placeholder
            'website' => 'https://www.' . Str::slug($name) . '.com',
            'description' => $this->faker->paragraphs(3, true),
            'industry' => $this->faker->randomElement([
                'Technology', 'Finance', 'Healthcare', 'Education', 
                'Manufacturing', 'Retail', 'Media', 'Consulting'
            ]),
            'size' => $this->faker->randomElement([
                '1-10', '11-50', '51-200', '201-500', '501-1000', '1000+'
            ]),
            'founded_year' => $this->faker->year('now'),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
        ];
    }
}
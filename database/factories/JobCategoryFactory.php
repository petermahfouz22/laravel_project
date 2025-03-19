<?php

namespace Database\Factories;

use App\Models\JobCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class JobCategoryFactory extends Factory
{
    protected $model = JobCategory::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => $this->faker->paragraph(),
        ];
    }
}
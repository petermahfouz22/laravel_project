<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'bio' => $this->faker->paragraphs(2, true),
            'location' => $this->faker->city() . ', ' . $this->faker->country(),
            'phone' => $this->faker->phoneNumber(),
            'profile_image' => 'profile-images/default.jpg',
            'linkedin_url' => 'https://linkedin.com/in/' . $this->faker->userName(),
            'website' => $this->faker->url(),
        ];
    }
}
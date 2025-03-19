<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'), // Default password for all test users
            'role' => $this->faker->randomElement(['employer', 'candidate']),
            'remember_token' => Str::random(10),
        ];
    }

    // State method to create admin users
    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'admin',
            ];
        });
    }

    // State method to create employer users
    public function employer()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'employer',
            ];
        });
    }

    // State method to create candidate users
    public function candidate()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'candidate',
            ];
        });
    }
}
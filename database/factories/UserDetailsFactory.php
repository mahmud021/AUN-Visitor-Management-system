<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\userDetails>
 */
class UserDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'school_id' => fake()->numerify('A000#####'),
            'role' => fake()->randomElement(['Staff', 'Student']),
            'status' => fake()->randomElement(['Active', 'Inactive', 'Graduated']),
            'telephone' => fake()->phoneNumber(),

        ];
    }
}

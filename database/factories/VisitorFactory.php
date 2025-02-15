<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Generates a new User instance for the foreign key.
            'user_id'          => User::factory(),
            'first_name'       => fake()->firstName,
            'last_name'        => fake()->lastName,
            'telephone'        => fake()->phoneNumber,
            // Generate a random future date for expected arrival (formatted as Y-m-d)
            'expected_arrival' => fake()->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            // Randomly select a status from the available options.
            'status'           => fake()->randomElement(['pending',]),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Visitor $visitor) {
            \App\Models\UserDetails::factory()->create([
                'user_id' => $visitor->user_id,
            ]);

            \App\Models\TimelineEvent::factory()->create([
                'visitor_id'  => $visitor->id,
                'user_id'     => $visitor->user_id,
                'event_type'  => 'created',
                'description' => 'Visitor record created automatically',
                'occurred_at' => now(),
            ]);
        });
    }


}

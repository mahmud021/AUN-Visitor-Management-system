<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        // Generate a random date (within a month before or after today)
        $visitDate = $this->faker->dateTimeBetween('-1 month', '+1 month');

        // Generate a random start time and then an end time a few hours later.
        $startTime = $this->faker->time('H:i:s');
        $endTime = $this->faker->time('H:i:s');

        return [
            // Generates a new User instance for the foreign key.
            'user_id'      => User::factory(),
            'first_name'   => $this->faker->firstName,
            'last_name'    => $this->faker->lastName,
            'telephone'    => $this->faker->phoneNumber,
            // Use the visit_date field as defined in your migration.
            'visit_date' => $this->faker->dateTimeBetween(now()->startOfWeek(), now()->endOfWeek())->format('Y-m-d'),
            'start_time'   => $startTime,
            'end_time'     => $endTime,
            // Generate a random 4-character visitor code.
            'visitor_code' => strtoupper($this->faker->lexify('????')),
            // Randomly select a status from the available options.
            'status'       => $this->faker->randomElement([
                'pending', 'approved', 'denied', 'checked_in', 'checked_out'
            ]),
            // Optional timestamp fields: you can add logic here to set these based on status if needed.
            'approved_at'  => null,
            'checked_in_at'=> null,
            'checked_out_at'=> null,
            'denied_at'    => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (\App\Models\Visitor $visitor) {
            // Create a related UserDetails record.
            \App\Models\UserDetails::factory()->create([
                'user_id' => $visitor->user_id,
            ]);

            // Create a timeline event for the visitor creation.
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

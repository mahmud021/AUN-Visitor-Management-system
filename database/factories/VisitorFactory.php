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
        // Determine the status first to set timestamps accordingly
        $status = $this->faker->randomElement(['pending', 'approved', 'denied', 'checked_in', 'checked_out']);

        // Initialize timestamp fields as null
        $approved_at = null;
        $checked_in_at = null;
        $checked_out_at = null;
        $denied_at = null;

        // Set timestamps based on status
        if ($status === 'approved') {
            $approved_at = now()->subHours(1);
        } elseif ($status === 'checked_in') {
            $approved_at = now()->subHours(2);
            $checked_in_at = now()->subHours(1);
        } elseif ($status === 'checked_out') {
            $approved_at = now()->subHours(3);
            $checked_in_at = now()->subHours(2);
            $checked_out_at = now()->subHours(1);
        } elseif ($status === 'denied') {
            $denied_at = now()->subHours(1);
        }

        // Generate two times and ensure end_time is after start_time
        $time1 = $this->faker->time('H:i:s');
        $time2 = $this->faker->time('H:i:s');
        $startTime = min($time1, $time2);
        $endTime = max($time1, $time2);

        return [
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'telephone' => $this->faker->phoneNumber,
            'location' => $this->faker->randomElement(['Reception', 'Conference Room', 'Lab', 'Office', 'Workshop']),
            'purpose_of_visit' => $this->faker->randomElement(['Meeting', 'Delivery', 'Interview', 'Maintenance', 'Tour']),
            'visit_date' => $this->faker->dateTimeBetween(now()->startOfWeek(), now()->endOfWeek())->format('Y-m-d'),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'visitor_code' => strtoupper($this->faker->lexify('????')),
            'status' => $status,
            'token' => $this->faker->isbn10(),
            'approved_at' => $approved_at,
            'checked_in_at' => $checked_in_at,
            'checked_out_at' => $checked_out_at,
            'denied_at' => $denied_at,
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
                'visitor_id' => $visitor->id,
                'user_id' => $visitor->user_id,
                'event_type' => 'created',
                'description' => 'Visitor record created automatically',
                'occurred_at' => now(),
            ]);
        });
    }
}

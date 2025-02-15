<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TimelineEvent>
 */
class TimelineEventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $eventTypes = ['created', 'approved', 'denied', 'checked_in', 'checked_out'];
        $eventType = $this->faker->randomElement($eventTypes);

        return [
            // Generate a new visitor record if one isn't provided.
            'visitor_id'  => Visitor::factory(),
            // Generate a new user record if one isn't provided.
            'user_id'     => User::factory(),
            // Set the event type randomly.
            'event_type'  => $eventType,
            // Create a default description based on the event type.
            'description' => ucfirst($eventType) . ' event for visitor',
            // Generate a fake datetime between one month ago and now.
            'occurred_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }
}

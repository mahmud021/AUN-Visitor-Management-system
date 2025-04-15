<?php

namespace Database\Factories;

use App\Models\Inventory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    protected $model = Inventory::class;

    public function definition(): array
    {
        $checkedInAt = $this->faker->dateTimeBetween('-30 days', 'now');
        $checkedOutAt = $this->faker->boolean(50)
            ? $this->faker->dateTimeBetween($checkedInAt, 'now')
            : null;

        return [
            'user_id' => User::factory(),
            'appliance_name' => $this->faker->randomElement([
                'Laptop', 'Monitor', 'Fan', 'Microwave', 'Refrigerator', 'Electric Kettle', 'Iron'
            ]),
            'location' => $this->faker->randomElement([
                'Dorm A', 'Dorm B', 'Admin Building', 'Library', 'IT Building'
            ]),
            'status' => $this->faker->randomElement([
                'pending', 'missing', 'checked_in', 'checked_out',
            ]),
            'brand' => $this->faker->company,  // Make sure the brand is always populated
            'image_path' => 'appliance_images/' . $this->faker->image('public/storage/appliance_images', 640, 480, null, false),
            'checked_in_at' => $checkedInAt,
            'checked_out_at' => $checkedOutAt,
        ];
    }
}

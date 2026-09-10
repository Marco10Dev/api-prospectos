<?php

namespace Database\Factories;

use App\Models\FollowUp;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FollowUp>
 */
class FollowUpFactory extends Factory
{

    public function definition(): array
    {
        return [
            'type'  => $this->faker->randomElement(['call', 'whatsapp', 'visit']),
            'notes' => $this->faker->sentence(10),
        ];
    }
}

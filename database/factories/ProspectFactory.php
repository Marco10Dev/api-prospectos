<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProspectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'   => $this->faker->name(),
            'phone'  => $this->faker->unique()->numerify('##########'),
            'email'  => $this->faker->safeEmail(),
            'status' => 'new'
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(2, true),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'place_id' => $this->faker->uuid(),
        ];
    }
}

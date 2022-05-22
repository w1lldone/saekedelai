<?php

namespace Database\Factories;

use App\Models\Planting;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'planting_id' => Planting::factory(),
            'packing_number' => $this->faker->numberBetween(1,300),
            'quantity' => $this->faker->numberBetween(50,100),
        ];
    }
}

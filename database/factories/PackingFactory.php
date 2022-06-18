<?php

namespace Database\Factories;

use App\Models\Packing;
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
            'initial_quantity' => $this->faker->numberBetween(50,100),
            'current_quantity' => $this->faker->numberBetween(50,100),
            'bag_size' => $this->faker->numberBetween(30, 50),
            'grade' => $this->faker->randomElement(Packing::getGrades())
        ];
    }
}

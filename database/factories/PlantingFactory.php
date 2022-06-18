<?php

namespace Database\Factories;

use App\Models\Field;
use App\Models\Planting;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlantingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'field_id' => Field::factory(),
            'started_at' => now(),
            'seed_variety' => $this->faker->randomElement(Planting::getSeedVarieties()),
            'seed_quantity' => $this->faker->numberBetween(1, 500),
            'harvested_at' => now()->addMonths(5)
        ];
    }
}

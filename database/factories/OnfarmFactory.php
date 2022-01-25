<?php

namespace Database\Factories;

use App\Models\Planting;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnfarmFactory extends Factory
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
            'timestamp' => now(),
            'activity' => $this->faker->word,
            'category' => $this->faker->word,
            'cost' => $this->faker->numberBetween(1, 30) * 100000,
            'notes' => $this->faker->sentence()
        ];
    }
}

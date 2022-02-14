<?php

namespace Database\Factories;

use App\Models\Onfarm;
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
            'name' => $this->faker->word,
            'started_at' => now(),
            'finished_at' => now()->addWeek(),
            'category' => $this->faker->randomElement(Onfarm::getCategories()),
            'description' => $this->faker->sentence(),
            'costs' => [
                [
                    'value' => 300000,
                    'description' => "penanaman"
                ],
                [
                    'value' => 2500000,
                    'description' => 'olah lahan'
                ]
            ],
        ];
    }
}

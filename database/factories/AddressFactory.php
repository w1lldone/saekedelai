<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'addressable_type' => User::class,
            'addressable_id' => User::factory(),
            'province' => $this->faker->word,
            'city' => $this->faker->word,
            'district' => $this->faker->word,
            'subdistrict' => $this->faker->word,
            'address' => $this->faker->word,
        ];
    }
}

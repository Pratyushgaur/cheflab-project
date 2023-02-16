<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RiderIncentivesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "amount" => $this->faker->numberBetween(1000, 10000),

        ];
    }
}

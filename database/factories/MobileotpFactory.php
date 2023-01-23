<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MobileotpFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "mobile_number" => $this->faker->unique()->numberBetween(1000000000, 2147483647),
            "otp" => "1234",
        ];
    }
}

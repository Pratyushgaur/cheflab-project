<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "email" => $this->faker->unique()->safeEmail,
            "password" => bcrypt("password"),
            "deal_categories" => $this->faker->text(),
            "mobile" => $this->faker->unique()->numberBetween(1000000000, 2147483647),
            "tax" => $this->faker->numberBetween(1000, 20000),
            "vendor_type" => $this->faker->randomElement(['restaurant', 'chef']),
        ];
    }
}

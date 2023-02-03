<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class Deliver_boyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->name,
            "email" => $this->faker->unique()->safeEmail,
            "username" => $this->faker->unique()->userName,
            "password" => bcrypt("password"),
            "mobile" => $this->faker->unique()->numberBetween(100000000, 2147483647),
            "city" => $this->faker->city,
            "pincode" => $this->faker->postcode,
            "identity_image" => $this->faker->imageUrl(),
            "identity_number" => $this->faker->sentence(1),
            "join_date" => $this->faker->date(),
        ];
    }
}

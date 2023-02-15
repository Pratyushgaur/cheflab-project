<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "order_id" => $this->faker->randomDigit,
            "customer_name" => $this->faker->firstName("male"),
            "delivery_address" => $this->faker->address,
            "landmark_address" => $this->faker->address,
            "mobile_number" => $this->faker->unique()->numberBetween(1000000000, 2147483647),
            "lat" => $this->faker->latitude,
            "long" => $this->faker->longitude,
            "total_amount" => $this->faker->numberBetween(1000, 20000),
            "gross_amount" => $this->faker->numberBetween(1000, 20000),
            "net_amount" => $this->faker->numberBetween(1000, 20000),
            "platform_charges" => $this->faker->numberBetween(1000, 20000),
            "tex" => $this->faker->numberBetween(1000, 20000),
        ];
    }
}

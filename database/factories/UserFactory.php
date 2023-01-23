<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'surname' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            "mobile_number" => $this->faker->unique()->numberBetween(100000000, 2147483647),
            "alternative_number" => $this->faker->unique()->numberBetween(100000000,2147483647),
            "image" => $this->faker->imageUrl(),
            "referralCode" =>  Str::random(10),
        ];
    }
}

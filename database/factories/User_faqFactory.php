<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class User_faqFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "faq_question" => $this->faker->paragraph(),
            "faq_answer" => $this->faker->paragraph(),
        ];
    }
}

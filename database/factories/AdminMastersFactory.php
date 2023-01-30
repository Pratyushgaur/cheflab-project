<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AdminMastersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'privacy_policy' => $this->faker->sentence(),
            'terms_conditions_vendor' => $this->faker->sentence(),
            'terms_conditions_cheflab' => $this->faker->sentence(),
            'terms_conditions_deliverboy' => $this->faker->sentence(),
            'refund_cancellation_cheflab' => $this->faker->sentence(),
            'aboutus' => $this->faker->sentence(),
            'delivery_charges_fix' => $this->faker->sentence(),
            'delivery_charges_per_km' => $this->faker->sentence(),
            'company_name' => $this->faker->sentence(),
            'logo' => $this->faker->sentence(),
            'favicon' => $this->faker->sentence(),
            'app_run' => $this->faker->sentence(),
            'app_close_reason' => $this->faker->sentence(),
            'goofle_map_key' => $this->faker->sentence(),
            'razorpay_publish_key' => $this->faker->sentence(),
            'dine_out_reject_reason' => $this->faker->sentence(),
            'user_app_current_version' => $this->faker->sentence(),
            'user_app_force_update' => $this->faker->sentence(),
            'user_app_soft_update' => $this->faker->sentence(),
            'driver_app_current_version' => $this->faker->sentence(),
            'driver_app_force_update' => $this->faker->sentence(),
            'driver_app_soft_update' => $this->faker->sentence(),
            "max_cod_amount" => $this->faker->sentence(),
            "max_preparation_time" => $this->faker->sentence(),
        ];
    }
}

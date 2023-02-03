<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_user_id_in_home_api()
    {
        // $response = $this->postJson(route("rider.home"), ["user_id" => ""]);
        // $response->assertJsonStructure([
        //     "error"
        // ]);
        // $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
    }

    public function test_it_can_get_the_data_succefully_when_order_does_not_exist()
    {
        // $deliveryBoy = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890"]);
        // dd($deliveryBoy);
        // $response = $this->postJson(route("rider.home"), ["user_id" => ""]);
        // $response->assertJsonStructure([
        //     "error"
        // ]);
        // $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
    }
}

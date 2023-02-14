<?php

namespace Tests\Feature\Rider;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PickupOtpCheck extends TestCase
{
    public function test_it_can_check_the_required_validation_of_order_status()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "status" => "",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The order row id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The rider assign order id field is required.", $response->json()["error"][2]);
        $this->assertStringContainsString("The status field is required.", $response->json()["error"][3]);
    }
}

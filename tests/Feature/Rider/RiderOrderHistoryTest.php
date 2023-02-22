<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class RiderOrderHistoryTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_order_history()
    {
        $response = $this->postJson(route("rider.order.history"), [
            "offset" => "",
            "user_id" => "",
            "status" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The offset field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The status field is required.", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_numeric_validation_of_order_history()
    {
        $response = $this->postJson(route("rider.order.history"), [
            "offset" => "axz",
            "user_id" => "axs",
            "status" => "axx",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The offset must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][1]);
    }
}

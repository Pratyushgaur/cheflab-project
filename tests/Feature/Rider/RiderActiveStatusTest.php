<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class RiderActiveStatusTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_rider_active_status()
    {
        $response = $this->postJson(route("rider.active.status"), [
            "user_id" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_numeric_validation_of_rider_active_status()
    {
        $response = $this->postJson(route("rider.active.status"), [
            "user_id" => "asbs",
        ]);

        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_not_exists_validation_of_rider_active_status()
    {
        $response = $this->postJson(route("rider.active.status"), [
            "user_id" => "123",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    }
}

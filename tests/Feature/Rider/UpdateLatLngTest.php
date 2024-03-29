<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class UpdateLatLngTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_lat_and_lang()
    {
        $response = $this->postJson(route("rider.latlng.update"), [
            "user_id" => "",
            "lng" => "",
            "lat" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lat field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The lng field is required.", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_numeric_validation_of_lat_and_lang()
    {
        $response = $this->postJson(route("rider.latlng.update"), [
            "user_id" => "asbs",
            "lng" => "12.11",
            "lat" => "12.11",
        ]);

        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_not_exists_validation_of_lat_and_lang()
    {
        $response = $this->postJson(route("rider.latlng.update"), [
            "user_id" => "123",
            "lng" => "12.11",
            "lat" => "12.11",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    }

    public function test_it_can_update_the_lat_and_lang()
    {
        $deliveryBoy =  $this->createDeliveryBoy();
        $response = $this->postJson(route("rider.latlng.update"), [
            "user_id" => $deliveryBoy->id,
            "lng" => "12.11",
            "lat" => "12.11",
        ]);
        $response->assertJsonStructure([
            "message"
        ]);
        $this->assertDatabaseHas("deliver_boy", [
            "lng" => "12.11",
            "lat" => "12.11"
        ]);
    }
}

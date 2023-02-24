<?php

namespace Tests\Feature;

use Tests\TestCase;

class RestaurantHomeTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
        $this->authUser();
    }

    public function test_it_can_check_the_required_validation_of_restaurant_home()
    {
        $response = $this->postJson(route("restaurant.home"), [
            "lng" => "",
            "lat" => "",
            "vendor_offset" => "",
            'vendor_limit'   => "",
            'product_offset' => "",
            'product_limit'  => "",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The lat field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lng field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The vendor offset field is required.", $response->json()["error"][2]);
        $this->assertStringContainsString("The vendor limit field is required.", $response->json()["error"][3]);
        $this->assertStringContainsString("The product offset field is required.", $response->json()["error"][4]);
        $this->assertStringContainsString("The product limit field is required.", $response->json()["error"][5]);
    }

    public function test_it_can_check_the_numeric_validation_of_restaurant_home()
    {
        $response = $this->postJson(route("restaurant.home"), [
            "lng" => "xyz",
            "lat" => "xzy",
            "vendor_offset" => "xyz",
            'vendor_limit'   => "xyz",
            'product_offset' => "xyz",
            'product_limit'  => "xyz",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The lat must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lng must be a number.", $response->json()["error"][1]);
        $this->assertStringContainsString("The vendor offset must be a number.", $response->json()["error"][2]);
        $this->assertStringContainsString("The vendor limit must be a number", $response->json()["error"][3]);
        $this->assertStringContainsString("The product offset must be a number.", $response->json()["error"][4]);
        $this->assertStringContainsString("The product limit must be a number.", $response->json()["error"][5]);
    }
}

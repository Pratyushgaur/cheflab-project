<?php

namespace Tests\Feature;

use Tests\TestCase;

class RestaurantByCategoryTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
        $this->authUser();
    }

    public function test_it_can_check_the_required_validation_of_by_category()
    {
        $response = $this->postJson(route("get.restaurant.by.category"), [
            'category_id'   => "",
            'lat'           => "",
            'lng'           => "",
            'vendor_offset' => "",
            'vendor_limit'  => "",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The category id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lat field is required", $response->json()["error"][1]);
        $this->assertStringContainsString("The lng field is required.", $response->json()["error"][2]);
        $this->assertStringContainsString("The vendor offset field is required.", $response->json()["error"][3]);
        $this->assertStringContainsString("The vendor limit field is required.", $response->json()["error"][4]);
    }

    public function test_it_can_check_the_numeric_validation_of_by_category()
    {
        $response = $this->postJson(route("get.restaurant.by.category"), [
            'category_id'   => "xyz",
            'lat'           => "xyz",
            'lng'           => "xyz",
            'vendor_offset' => "xyz",
            'vendor_limit'  => "xyz",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The category id must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lat must be a number.", $response->json()["error"][1]);
        $this->assertStringContainsString("The lng must be a number", $response->json()["error"][2]);
        $this->assertStringContainsString("The vendor offset must be a number.", $response->json()["error"][3]);
        $this->assertStringContainsString("The vendor limit must be a number.", $response->json()["error"][4]);
    }
}

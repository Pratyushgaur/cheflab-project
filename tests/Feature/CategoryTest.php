<?php

namespace Tests\Feature;

use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
        $this->authUser();
    }

    public function test_it_can_check_the_required_validation_of_categories()
    {
        $response = $this->postJson(route("get.categories"), [
            "lng" => "",
            "lat" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The lat field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lng field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_categories()
    {
        $response = $this->postJson(route("get.categories"), [
            "lng" => "xyz",
            "lat" => "xyz",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The lat must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lng must be a number.", $response->json()["error"][1]);
    }
}

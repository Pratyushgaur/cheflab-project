<?php

namespace Tests\Feature;

use Tests\TestCase;

class CuisinesTest extends TestCase
{
    public function setup(): void
    {
        parent::setup();
        $this->authUser();
    }

    public function test_it_can_check_the_required_validation_of_cuisines()
    {
        $response = $this->postJson(route("get.cuisines"), [
            "lng" => "",
            "lat" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The lat field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The lng field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_cuisines()
    {
        $response = $this->postJson(route("get.cuisines"), [
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

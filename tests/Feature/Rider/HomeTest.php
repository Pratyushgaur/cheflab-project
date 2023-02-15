<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class HomeTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_user_id_in_home_api()
    {
        $response = $this->postJson(route("rider.home"), ["user_id" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_numeric_validation_of_user_id_in_home_api()
    {
        $response = $this->postJson(route("rider.home"), ["user_id" => "asy"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }


    public function test_it_can_check_the_user_id_not_exist_in_home_api()
    {
        $response = $this->postJson(route("rider.home"), ["user_id" => 12]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    }
}

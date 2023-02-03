<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class ProfileTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_user_id_in_home_api()
    {
        $response = $this->postJson(route("rider.profile"), ["user_id" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_rider_existed_or_not()
    {
        $response = $this->postJson(route("rider.profile"), ["user_id" => "3"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_rider()
    {
        $response = $this->postJson(route("rider.profile"), ["user_id" => "as"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }
}

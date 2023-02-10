<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

use Illuminate\Support\Str;

class RegisterTokenTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_user_id_and_token_register_api()
    {
        $response = $this->postJson(route("rider.register.token"), ["user_id" => "", "token" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The token field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_user_id_register_api()
    {
        $response = $this->postJson(route("rider.register.token"), ["user_id" => "string", "token" => "abcd"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }

    public function test_it_can_register_the_token_in_the_delivery_boy_token_table()
    {
        $deliveryBoy = $this->createDeliveryBoy();

        // $deliveryBoyToken =  $this->createDeliveryBoyTokens([
        //     "rider_id" => $deliveryBoy->id,
        // ]);
        $token = Str::random(32);

        $response = $this->postJson(route("rider.register.token"), [
            "user_id" => $deliveryBoy->id,
            "token" => $token,
        ]);

        $response->assertJsonStructure([
            "message"
        ]);

        $this->assertStringContainsString("Token Register Successfully", $response->json()["message"]);
        $this->assertDatabaseHas("delivery_boy_tokens", [
            "rider_id" => $deliveryBoy->id,
            "token" => $token,
        ]);
    }

    public function test_it_can_not_register_the_token_in_the_delivery_boy_tokens_table()
    {
        $deliveryBoy = $this->createDeliveryBoy();

        $deliveryBoyToken =  $this->createDeliveryBoyTokens([
            "rider_id" => $deliveryBoy->id,
        ]);

        $response = $this->postJson(route("rider.register.token"), [
            "user_id" => $deliveryBoy->id,
            "token" => $deliveryBoyToken->token,
        ]);

        $response->assertJsonStructure([
            "message"
        ]);

        $this->assertStringContainsString("Token Register Successfully", $response->json()["message"]);
        $this->assertDatabaseHas("delivery_boy_tokens", [
            "rider_id" => $deliveryBoy->id,
            "token" => $deliveryBoyToken->token,
        ]);
    }
}

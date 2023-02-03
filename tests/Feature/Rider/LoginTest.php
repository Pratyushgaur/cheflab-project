<?php

namespace Tests\Feature\Rider;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_mobile_in_the_otp_send()
    {
        $response = $this->postJson(route("rider.otp.send"), ["username" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The username field is required.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_otp_send()
    {
        $response = $this->postJson(route("rider.otp.send"), ["username" => "asdfadf"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The username must be a number.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_digits_validation()
    {
        $response = $this->postJson(route("rider.otp.send"), ["username" => "12345678902"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The username must be 10 digits.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_not_found_validation()
    {
        $response = $this->postJson(route("rider.otp.send"), ["username" => "1234567890"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("User Not Found", $response->json()["error"]);
    }

    public function test_it_check_the_delivery_boy_status_0()
    {
        $user = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890", "status" => 0]);
        $response = $this->postJson(route("rider.otp.send"), ["username" => $user->username]);
        $response->assertJsonStructure([
            "status",
            "error",
        ]);
        $this->assertStringContainsString("Your Account is Inactive. cantact with admin to process", $response->json()["error"]);
    }

    public function test_it_can_send_the_otp_to_the_user()
    {
        Http::fake([
            "http://bulksms.msghouse.in/*" => Http::response([], 200)
        ]);
        $user = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890"]);
        $response = $this->postJson(route("rider.otp.send"), ["username" => $user->username]);
        $response->assertJsonStructure([
            "message",
            "otp",
            "mobile"
        ]);

        $this->assertStringContainsString("Otp Send Successfully", $response->json()["message"]);
        $this->assertStringContainsString($user->mobile, $response->json()["mobile"]);
    }
}

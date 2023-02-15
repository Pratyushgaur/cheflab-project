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
        $deliveryBoy = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890", "status" => 0]);
        $response = $this->postJson(route("rider.otp.send"), ["username" => $deliveryBoy->username]);
        $response->assertJsonStructure([
            "status",
            "error",
        ]);
        $this->assertStringContainsString("Your Account is Inactive. contact with admin to process", $response->json()["error"]);
    }

    public function test_it_can_send_the_otp_to_the_user()
    {
        Http::fake([
            "http://bulksms.msghouse.in/*" => Http::response([], 200)
        ]);
        $deliveryBoy = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890"]);
        $response = $this->postJson(route("rider.otp.send"), ["username" => $deliveryBoy->username]);
        $response->assertJsonStructure([
            "message",
            "otp",
            "mobile"
        ]);

        $this->assertStringContainsString("Otp Send Successfully", $response->json()["message"]);
        $this->assertStringContainsString($deliveryBoy->mobile, $response->json()["mobile"]);
    }

    public function test_it_can_check_the_required_validation_of_mobile_otp_verify()
    {
        $response = $this->postJson(route("rider.otp.verify"), ["mobile_number" => "", "otp" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("otp field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_otp_verify()
    {
        $response = $this->postJson(route("rider.otp.verify"), ["mobile_number" => "asdfadf", "otp" => "abcd"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("number", $response->json()["error"][0]);
        $this->assertStringContainsString("number", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_and_otp_should_be_4_digits_validation()
    {
        $response = $this->postJson(route("rider.otp.verify"), ["mobile_number" => "12345678902", "otp" => "123456"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("10 digits", $response->json()["error"][0]);
        $this->assertStringContainsString("4 digits", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_otp_invalid_validation()
    {
        $deliveryBoy = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890"]);
        $this->createRiderOtp(["mobile_number" => $deliveryBoy->mobile]);

        $response = $this->postJson(route("rider.otp.verify"), ["mobile_number" => $deliveryBoy->mobile, "otp" => "1233"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Invalid OTP", $response->json()["error"]);
    }

    public function test_it_can_login_with_otp()
    {
        $deliveryBoy = $this->createDeliveryBoy(["username" => "1234567890", "mobile" => "1234567890"]);
        $this->createRiderOtp(["mobile_number" => $deliveryBoy->mobile]);

        $response = $this->postJson(route("rider.otp.verify"), ["mobile_number" => $deliveryBoy->mobile, "otp" => "1234"]);
        $response->assertJsonStructure([
            "message",
            "user"
        ]);
        $this->assertStringContainsString($deliveryBoy->mobile, $response->json()["user"]["mobile"]);
    }

    public function test_check_the_required_field_of_app_version()
    {
        $response = $this->postJson(route("rider.update.version"), ["version" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The version field is required.", $response->json()["error"][0]);
    }

    public function test_check_the_app_version_and_send_back_empty_array()
    {
        $this->createAdminMasters(
            [
                "driver_app_current_version" => "2.0",
                "driver_app_force_update" => "2.0",
                "driver_app_soft_update" => "2.0"
            ]
        );
        $response = $this->postJson(route("rider.update.version"), ["version" => "2.0"]);
        $response->assertJsonStructure([
            "data" => []
        ]);
        $response->assertJsonCount(0, "data");
    }

    public function test_check_the_app_version_if_version_is_less_then_sent_the_values()
    {
        $this->createAdminMasters([
            "driver_app_current_version" => "2.0",
            "driver_app_force_update" => "2.0",
            "driver_app_soft_update" => "2.0"
        ]);
        $response = $this->postJson(route("rider.update.version"), ["version" => "1.0"]);
        $response->assertJsonStructure([
            "data" => [
                "current_version",
                "force_update",
                "user_app_soft_update",
            ]
        ]);
    }
}

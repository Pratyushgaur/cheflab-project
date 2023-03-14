<?php

namespace Tests\Feature\Login;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LoginTest extends TestCase
{

    public function test_it_can_check_the_required_validation_of_mobile_in_the_otp_send()
    {
        $response = $this->postJson(route("login.otp.send"), ["mobile_number" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("required", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_otp_send()
    {
        $response = $this->postJson(route("login.otp.send"), ["mobile_number" => "asdfadf"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("number", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_digits_validation()
    {
        $response = $this->postJson(route("login.otp.send"), ["mobile_number" => "12345678902"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("10 digits", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_not_found_validation()
    {
        $response = $this->postJson(route("login.otp.send"), ["mobile_number" => "1234567890"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Not Found", $response->json()["error"]);
    }

    public function test_it_can_send_the_deactivate_message_to_the_user()
    {
        Http::fake([
            "http://bulksms.msghouse.in/*" => Http::response([], 200)
        ]);
        $user = $this->createUser(["mobile_number" => "1234567890"]);
        $response = $this->postJson(route("login.otp.send"), ["mobile_number" => $user->mobile_number]);
        $response->assertJsonStructure([
            "error",
        ]);
    }

    public function test_it_can_check_the_required_validation_of_mobile_otp_verify()
    {
        $response = $this->postJson(route("login.verify.otp"), ["mobile_number" => "", "otp" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("otp field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_otp_verify()
    {
        $response = $this->postJson(route("login.verify.otp"), ["mobile_number" => "asdfadf", "otp" => "abcd"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("number", $response->json()["error"][0]);
        $this->assertStringContainsString("number", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_and_otp_should_be_4_digits_validation()
    {
        $response = $this->postJson(route("login.verify.otp"), ["mobile_number" => "12345678902", "otp" => "123456"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("10 digits", $response->json()["error"][0]);
        $this->assertStringContainsString("4 digits", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_otp_invalid_validation()
    {
        $user = $this->createUser(["mobile_number" => "1234567890"]);
        $this->createOtp(["mobile_number" => $user->mobile_number]);

        $response = $this->postJson(route("login.verify.otp"), ["mobile_number" => $user->mobile_number, "otp" => "1233"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Invalid OTP", $response->json()["error"]);
    }

    public function test_it_can_login_with_otp()
    {
        $user = $this->createUser(["mobile_number" => "1234567890"]);
        $this->createOtp(["mobile_number" => $user->mobile_number]);

        $response = $this->postJson(route("login.verify.otp"), ["mobile_number" => $user->mobile_number, "otp" => "1234"]);
        $response->assertJsonStructure([
            "message",
            "token"
        ]);
        $this->assertStringContainsString($user->mobile_number, $response->json()["token"]["mobile"]);
    }

    public function test_check_the_required_field_of_app_version()
    {
        $response = $this->postJson(route("update.version"), ["version" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The version field is required.", $response->json()["error"][0]);
    }

    public function test_check_the_app_version_and_send_back_empty_array()
    {
        $this->createAdminMasters(
            [
                "user_app_current_version" => "2.0",
                "user_app_force_update" => "2.0",
                "user_app_soft_update" => "2.0",
                "ios_user_app_version" => "2.0"
            ]
        );
        $response = $this->postJson(route("update.version"), ["version" => "2.0"]);
        $response->assertJsonStructure([
            "data" => []
        ]);
        $response->assertJsonCount(0, "data");
    }

    public function test_check_the_app_version_if_version_is_less_then_sent_the_values()
    {
        $this->createAdminMasters([
            "user_app_current_version" => "2.0",
            "user_app_force_update" => "2.0",
            "user_app_soft_update" => "2.0",
            "ios_user_app_version" => "2.0"
        ]);
        $response = $this->postJson(route("update.version"), ["version" => "1.0"]);
        $response->assertJsonStructure([
            "data" => [
                "current_version",
                "force_update",
                "user_app_soft_update",
            ]
        ]);
    }
}

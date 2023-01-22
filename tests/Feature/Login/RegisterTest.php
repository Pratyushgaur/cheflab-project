<?php

namespace Tests\Feature\Login;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_mobile_in_the_register_otp_send()
    {
        $response = $this->postJson(route("register.otp.send"), ["mobile_number" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("required", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_register_otp_send()
    {
        $response = $this->postJson(route("register.otp.send"), ["mobile_number" => "asdfadf"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("number", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_digits_validation()
    {
        $response = $this->postJson(route("register.otp.send"), ["mobile_number" => "12345678902"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("10 digits", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_mobile_number_already_existed_validation()
    {
        $user = $this->createUser();
        $response = $this->postJson(route("register.otp.send"), ["mobile_number" => $user->mobile_number]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Already Have Register this Number", $response->json()["error"]);
    }

    public function test_it_can_send_the_otp_to_the_user()
    {
        Http::fake([
            "http://bulksms.msghouse.in/*" => Http::response([], 200)
        ]);

        $response = $this->postJson(route("register.otp.send"), ["mobile_number" => "1234567890"]);
        $response->assertJsonStructure([
            "message",
            "mobile_number",
            "otp"
        ]);
        $this->assertStringContainsString("otp Generated", $response->json()["message"]);
    }

    public function test_it_can_check_the_required_validation_of_mobile_otp_verify()
    {
        $response = $this->postJson(route("register.otp.verify"), ["mobile_number" => "", "otp" => ""]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("otp field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_mobile_in_the_otp_verify()
    {
        $response = $this->postJson(route("register.otp.verify"), ["mobile_number" => "asdfadf", "otp" => "abcd"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("number", $response->json()["error"][0]);
        $this->assertStringContainsString("number", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_mobile_number_should_be_10_and_otp_should_be_4_digits_validation()
    {
        $response = $this->postJson(route("register.otp.verify"), ["mobile_number" => "12345678902", "otp" => "123456"]);
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

        $response = $this->postJson(route("register.otp.verify"), ["mobile_number" => $user->mobile_number, "otp" => "1233"]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Invalid OTP", $response->json()["error"]);
    }

    public function test_it_can_register_with_otp()
    {
        $user = $this->createUser(["mobile_number" => "1234567890"]);
        $this->createOtp(["mobile_number" => $user->mobile_number]);

        $response = $this->postJson(route("register.otp.verify"), ["mobile_number" => $user->mobile_number, "otp" => "1234"]);
        $response->assertJsonStructure([
            "message",
            "mobile_number"
        ]);
        $this->assertStringContainsString($user->mobile_number, $response->json()["mobile_number"]);
        $this->assertStringContainsString("Verified", $response->json()["message"]);
    }
}

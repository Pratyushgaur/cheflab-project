<?php

namespace Tests\Feature\Login;

use Tests\TestCase;

class RegisterVerifyTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_register_verify_user()
    {
        $response = $this->postJson(route("register.user.verify"), []);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number field is required", $response->json()["error"][0]);
        $this->assertStringContainsString("name field is required", $response->json()["error"][1]);
        $this->assertStringContainsString("lastname field is required", $response->json()["error"][2]);
        $this->assertStringContainsString("email field is required", $response->json()["error"][3]);
    }

    public function test_it_can_check_the_numeric_validation_of_register_verify_user()
    {
        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => "abca",
            "name" => "test",
            "lastname" => "lastname",
            "email" => "xyz@gmail.com",
            "alternative_mobile" => "abc"
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number must be a number", $response->json()["error"][0]);
        $this->assertStringContainsString("mobile number must be 10 digits", $response->json()["error"][1]);
        $this->assertStringContainsString("alternative mobile must be a number", $response->json()["error"][2]);
        $this->assertStringContainsString("alternative mobile must be 10 digits", $response->json()["error"][3]);
    }

    public function test_it_can_check_the_unique_validation_of_register_verify_user()
    {
        $user =  $this->createUser(["mobile_number" => "1234567890", "alternative_number" => "1234567890", "email" => "xyz@gmail.com"]);
        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => $user->mobile_number,
            "name" => "test",
            "lastname" => "lastname",
            "email" => $user->email,
            "alternative_mobile" => $user->alternative_number
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("mobile number has already been taken", $response->json()["error"][0]);
        $this->assertStringContainsString("email has already been taken.", $response->json()["error"][1]);
        $this->assertStringContainsString("alternative mobile has already been taken", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_max_validation_of_register_verify_user()
    {
        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => "1234567890",
            "name" => "testing the value please throw an error",
            "lastname" => "testing the value please throw an error",
            "email" => "xyz@gmail.com",
            "alternative_mobile" => "1234567890",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("name may not be greater than 20 characters", $response->json()["error"][0]);
        $this->assertStringContainsString("lastname may not be greater than 20 characters", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_email_validation_of_register_verify_user()
    {
        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => "1234567890",
            "name" => "testing ",
            "lastname" => "testing",
            "email" => "xyz",
            "alternative_mobile" => "1234567890",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The email must be a valid email address", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_verify_otp_of_register_verify_user()
    {
        $user = $this->createUser(["mobile_number" => "1234567890"]);
        $this->createOtp(["mobile_number" => $user->mobile_number]);

        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => "1234567895",
            "name" => "testing ",
            "lastname" => "testing",
            "email" => "xyz@gmail.com",
            "alternative_mobile" => "1234567890",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("OTP is not verified", $response->json()["error"]);
    }

    public function test_it_can_check_the_validation_of_referral_code()
    {
        $this->createOtp(["mobile_number" => "1234567891", "status" => 1]);
        $response = $this->postJson(route("register.user.verify"), [
            "mobile_number" => "1234567891",
            "name" => "testing ",
            "lastname" => "testing",
            "email" => "xyz@gmail.com",
            "alternative_mobile" => "1234567890",
            "referralcode" => "123344"
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Invalid Referral Code", $response->json()["error"]);
    }
}

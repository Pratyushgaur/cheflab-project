<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class DeliveryOtpCheckTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_delivery_otp_check()
    {
        $response = $this->postJson(route("rider.delivery.otp"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "otp" => "",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The order row id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The rider assign order id field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The otp field is required.", $response->json()["error"][2]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][3]);
    }

    public function test_it_can_check_the_numeric_validation_of_delivery_otp_check()
    {
        $response = $this->postJson(route("rider.delivery.otp"), [
            "order_row_id" => "as",
            "user_id" => "ass",
            "rider_assign_order_id" => "122",
            "otp" => "1234",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The order row id must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_exist_validation_of_delivery_otp_check()
    {
        $response = $this->postJson(route("rider.delivery.otp"), [
            "order_row_id" => "1",
            "user_id" => "1",
            "rider_assign_order_id" => "1",
            "otp" => "1234",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected order row id is invalid.", $response->json()["error"][0]);
        $this->assertStringContainsString("The selected rider assign order id is invalid.", $response->json()["error"][1]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_invalid_otp_validation_of_delivery_otp_check()
    {
        $vendor = $this->createVendor();
        $user = $this->createUser();
        $order =  $this->createOrder([
            "vendor_id" => $vendor->id,
            "user_id" => $user->id,
        ]);
        $deliveryBoy = $this->createDeliveryBoy();
        $riderAssignOrder = $this->createRiderAssignOrders([
            "rider_id" => $deliveryBoy->id,
            "order_id" => $order->id,
            "otp" => 1234,
        ]);
        $response = $this->postJson(route("rider.delivery.otp"), [
            "order_row_id" => $order->id,
            "user_id" => $user->id,
            "rider_assign_order_id" => $riderAssignOrder->id,
            "otp" => 12345,

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("Invalid OTP", $response->json()["error"]);
    }
}

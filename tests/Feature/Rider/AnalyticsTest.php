<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class AnalyticsTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_analytics()
    {
        $response = $this->postJson(route("rider.analytics"), [
            "user_id" => "",
            "report_for" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The report for field is required.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_numeric_validation_of_analytics()
    {
        $response = $this->postJson(route("rider.analytics"), [
            "user_id" => "asbs",
            "report_for" => "todya",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][0]);
    }

    public function test_it_can_check_the_not_exists_validation_of_analytics()
    {
        $response = $this->postJson(route("rider.analytics"), [
            "user_id" => "123",
            "report_for" => "todya",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    }

    // public function test_it_can_check_the_today_analytics()
    // {
    //     $vendor = $this->createVendor();
    //     $user = $this->createUser();
    //     $order =  $this->createOrder([
    //         "vendor_id" => $vendor->id,
    //         "user_id" => $user->id,
    //     ]);
    //     $deliveryBoy = $this->createDeliveryBoy();
    //     $this->createRiderIncentives([
    //         "rider_id" => $deliveryBoy->id,
    //     ]);

    //     $this->createRiderReviewRatings([
    //         "user_id" =>  $user->id,
    //         "rider_id" => $deliveryBoy->id,
    //         "rating" => 4.2,
    //     ]);

    //     $this->createRiderAssignOrders([
    //         "rider_id" => $deliveryBoy->id,
    //         "order_id" => $order->id,
    //         "otp" => 1234,
    //     ]);

    //     $response = $this->postJson(route("rider.analytics"), [
    //         "user_id" => $deliveryBoy->id,
    //         "report_for" => "today",

    //     ]);
    //     dd($response->json());
    //     $response->assertJsonStructure([
    //         "error"
    //     ]);
    //     $this->assertStringContainsString("The selected user id is invalid.", $response->json()["error"][0]);
    // }
}

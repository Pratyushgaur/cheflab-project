<?php

namespace Tests\Feature\Rider;

use Tests\TestCase;

class OrderStatusTest extends TestCase
{
    public function test_it_can_check_the_required_validation_of_order_status()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "status" => "",

        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The order row id field is required.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id field is required.", $response->json()["error"][1]);
        $this->assertStringContainsString("The rider assign order id field is required.", $response->json()["error"][2]);
        $this->assertStringContainsString("The status field is required.", $response->json()["error"][3]);
    }

    public function test_it_can_check_the_numeric_validation_of_order_status()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "ads",
            "user_id" => "ass",
            "rider_assign_order_id" => "",
            "status" => "",

        ]);

        $response->assertJsonStructure([
            "error"
        ]);

        $this->assertStringContainsString("The order row id must be a number.", $response->json()["error"][0]);
        $this->assertStringContainsString("The user id must be a number.", $response->json()["error"][1]);
    }

    public function test_it_can_check_the_exists_validation_of_order_status()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "1",
            "user_id" => "1",
            "rider_assign_order_id" => "1",
            "status" => "",

        ]);

        $response->assertJsonStructure([
            "error"
        ]);

        $this->assertStringContainsString("The selected order row id is invalid.", $response->json()["error"][0]);
        $this->assertStringContainsString("The selected user id is invalid", $response->json()["error"][1]);
        $this->assertStringContainsString("The selected rider assign order id is invalid.", $response->json()["error"][2]);
    }

    public function test_it_can_check_the_required_validation_of_distance_and_earning_if_status_1()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "status" => "1",
            "distance" => "",
            "earning" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The distance field is required when status is 1.", $response->json()["error"][3]);
        $this->assertStringContainsString("The earning field is required when status is 1.", $response->json()["error"][4]);
    }

    public function test_it_can_check_the_required_validation_of_cancel_reason_if_status_2()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "status" => "2",
            "distance" => "",
            "earning" => "",
            "cancel_reason"
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The cancel reason field is required when status is 2.", $response->json()["error"][3]);
    }

    public function test_it_can_check_the_required_validation_of_otp_if_status_4()
    {
        $response = $this->postJson(route("rider.order.status"), [
            "order_row_id" => "",
            "user_id" => "",
            "rider_assign_order_id" => "",
            "status" => "4",
            "distance" => "",
            "earning" => "",
            "otp" => "",
        ]);
        $response->assertJsonStructure([
            "error"
        ]);
        $this->assertStringContainsString("The otp field is required when status is 4.", $response->json()["error"][3]);
    }
}

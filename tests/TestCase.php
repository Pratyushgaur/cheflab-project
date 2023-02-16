<?php

namespace Tests;

use App\Models\AdminMasters;
use App\Models\Deliver_boy;
use App\Models\DeliveryBoyTokens;
use App\Models\Mobileotp;
use App\Models\Order;
use App\Models\RiderAssignOrders;
use App\Models\RiderIncentives;
use App\Models\RiderMobileOtp;
use App\Models\RiderReviewRatings;
use App\Models\User;
use App\Models\User_faq;
use App\Models\Vendors;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;

    public function setup(): void
    {
        parent::setup();
        $this->withoutExceptionHandling();
    }

    public function createUser($args = [], $num = null)
    {
        return User::factory()->count($num)->create($args);
    }

    public function createOtp($args = [], $num = null)
    {
        return Mobileotp::factory()->count($num)->create($args);
    }

    public function createUserFaq($args = [], $num = null)
    {
        return User_faq::factory()->count($num)->create($args);
    }

    public function createAdminMasters($args = [], $num = null)
    {
        return AdminMasters::factory()->count($num)->create($args);
    }

    public function createDeliveryBoy($args = [], $num = null)
    {
        return Deliver_boy::factory()->count($num)->create($args);
    }
    public function createDeliveryBoyTokens($args = [], $num = null)
    {
        return DeliveryBoyTokens::factory()->count($num)->create($args);
    }

    public function createRiderOtp($args = [], $num = null)
    {
        return RiderMobileOtp::factory()->count($num)->create($args);
    }

    public function createOrder($args = [], $num = null)
    {
        return Order::factory()->count($num)->create($args);
    }

    public function createVendor($args = [], $num = null)
    {
        return Vendors::factory()->count($num)->create($args);
    }

    public function createRiderAssignOrders($args = [], $num = null)
    {
        return RiderAssignOrders::factory()->count($num)->create($args);
    }

    public function createRiderIncentives($args = [], $num = null)
    {
        return RiderIncentives::factory()->count($num)->create($args);
    }

    public function createRiderReviewRatings($args = [], $num = null)
    {
        return RiderReviewRatings::factory()->count($num)->create($args);
    }
}

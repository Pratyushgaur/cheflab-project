<?php

namespace Tests;

use App\Models\Mobileotp;
use App\Models\User;
use App\Models\User_faq;
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
}

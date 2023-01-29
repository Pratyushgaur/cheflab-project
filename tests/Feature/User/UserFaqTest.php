<?php

namespace Tests\Feature\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserFaqTest extends TestCase
{
    public function test_it_can_get_the_details_of_user_faq()
    {
        $this->createUserFaq();
        $response = $this->getJson(route("user.faq"));
        $response->assertJsonStructure([
            "message",
            "response" => [[
                "id",
                "faq_question",
                "faq_answer"
            ]]
        ]);
    }
}

<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    public function test_it_can_protect_endpoints()
    {
        $this->get('/api/authenticated_user')
            ->assertStatus(401)
        ;
    }
}

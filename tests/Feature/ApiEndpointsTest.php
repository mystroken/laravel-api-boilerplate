<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiEndpointsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_it_can_paginate_through_resources_list()
    {
        factory(\App\User::class, 10)->create();

        $this->get('/api/users?limit=3')
            ->assertJson([
                'meta' => [
                    'per_page' => 3
                ]
            ])
        ;
    }
}

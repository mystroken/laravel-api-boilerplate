<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UsersEndpointTest extends TestCase
{
    use DatabaseMigrations, AuthenticationEndpoints;


    public function test_it_can_fetch_users()
    {
        $this->seed( 'UsersTableSeeder' );

        $this->get('/api/users')
             ->assertJsonStructure([
                 'data' => [
                     '*' => [
                         'id', 'name', 'email'
                     ]
                 ]
             ])
        ;
    }

    public function test_it_can_fetch_a_single_user()
    {
        $this->seed( 'UsersTableSeeder' );

        $this->get('/api/users/1')
            ->assertJson([
                'data' => [
                    'id' => 1
                ]
            ])
        ;
    }

    public function test_it_can_create_a_user()
    {
        $user_data = [
            'name'     => 'Jane KWENE',
            'email'    => 'jane.kwene@email.test',
            'password' => 'secret'
        ];

        $this->post( '/api/users', $user_data )
            ->assertJsonStructure(['token'])
        ;
    }
}
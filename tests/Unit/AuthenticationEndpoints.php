<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestResponse;

Trait AuthenticationEndpoints
{
    public function test_it_can_authenticate_a_user()
    {
        $this->_authenticated_a_user()
             ->assertJsonStructure(['token'])
        ;
    }

    /**
     * @depends test_it_can_authenticate_a_user
     */
    public function test_it_can_return_authenticated_user_data()
    {
        $token = $this->_generate_a_valid_token( $this->_authenticated_a_user() );

        $this->withHeader( 'Authorization', 'Bearer ' . $token )
             ->get( '/api/authenticated_user' )
             ->assertJsonStructure([
                 'data' => [
                     'id', 'name', 'email'
                 ]
             ])
        ;
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function _authenticated_a_user()
    {
        $user = factory(\App\User::class)->create(['password' => bcrypt('foo')]);
        return $this->json( 'POST', '/api/authenticate', ['email' => $user->email, 'password' => 'foo'] );
    }

    /**
     * @param TestResponse $response
     *
     * @return string A valid token
     */
    private function _generate_a_valid_token(TestResponse $response)
    {
        return json_decode( $response->getContent() )->token;
    }
}

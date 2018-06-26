<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\TestResponse;

Trait AuthenticationEndpoints
{
    /**
     * @var array $fakeUserAttributes
     */
    private $fakeUserAttributes = [
        'name'     => 'Violet KWENE',
        'email'    => 'user@email.test',
        'password' => 'secret',
    ];


    public function test_it_can_authenticate_a_registered_user()
    {
        // Register our fake user.
        $this->_register_a_user();

        // The let's try login him
        $this->_authenticated_a_user()
             ->assertJsonStructure(['token'])
        ;
    }

    /**
     * @depends test_it_can_authenticate_a_registered_user
     */
    public function test_it_can_return_authenticated_user_data()
    {
        // Then get the token returned when the user is authenticated.
        $token = $this->_generate_a_valid_token();

        // Test if we are able to retrieve the user data.
        $this->_retrieve_authenticated_user_data( $token )
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
        $credentials = [
            'email'    => $this->fakeUserAttributes['email'],
            'password' => $this->fakeUserAttributes['password'],
        ];

        return $this->json( 'POST', '/api/authenticate', $credentials );
    }

    /**
     * @param string $token
     *
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function _retrieve_authenticated_user_data( $token )
    {
        return $this->withHeader( 'Authorization', 'Bearer ' . $token )->get( '/api/authenticated_user' );
    }

    /**
     * @return \Illuminate\Foundation\Testing\TestResponse
     */
    private function _register_a_user()
    {
        return $this->post( '/api/users', $this->fakeUserAttributes );
    }

    /**
     * @return string
     */
    private function _generate_a_valid_token()
    {
        // Register our fake user.
        $this->_register_a_user();
        return $this->_get_token_from_response( $this->_authenticated_a_user() );
    }

    /**
     * @return $this
     */
    private function _init_authenticated_request()
    {
        return $this->withHeader( 'Authorization', 'Bearer ' . $this->_generate_a_valid_token() );
    }

    /**
     * @param TestResponse $response
     *
     * @return string
     */
    private function _get_token_from_response(TestResponse $response)
    {
        return json_decode( $response->getContent() )->token;
    }
}

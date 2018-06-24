<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;

class AuthenticateController extends ApiController
{
    public function authenticate( Request $request )
    {
        // Grabs credentials from the request.
        $credentials = $request->only( 'email', 'password' );

        try {
            // Attempt to verify the credentials and create a token for the user.
            if ( ! $token = JWTAuth::attempt( $credentials ) ) {
                return response()->json( ['error' => 'invalid_credentials'], 401 );
            }
        } catch( JWTException $e ) {
            // Something went wrong whilst attempting to encode the token.
            return response()->json( ['error' => 'could_not_create_token'], 500 );
        }

        // All good, so return the token.
        return response()->json( compact( 'token' ) );
    }
}

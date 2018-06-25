<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\CssSelector\Exception\InternalErrorException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticateController extends ApiController
{
    /**
     *  API Login, on success return JWT Auth token
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
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

    /**
     * Log out
     * Invalidate the token, so user cannot use it anymore.
     * They have to relogin to get a new token.
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        $this->validate($request, [
            'token' => 'required',
        ]);

        JWTAuth::invalidate( $request->input( 'token' ) );
    }

    /**
     * Returns the authenticated user.
     *
     * @return UserResource|JsonResponse
     */
    public function authenticatedUser()
    {
        try {
            if ( ! $user = JWTAuth::parseToken()->authenticate() ) {
                return response()->json( ['user_not_found'], 404 );
            }
        } catch( TokenExpiredException $e ) {
            return response()->json( ['token_expired'], $e->getCode() );
        } catch( TokenInvalidException $e ) {
            return response()->json( ['token_invalid'], $e->getCode() );
        } catch( JWTException $e ) {
            return response()->json( ['token_absent'], $e->getCode() );
        }

        // the token is valid and we found the user via the sub claim.
        return new UserResource( $user );
    }

    /**
     * Refresh the token.
     *
     * @return mixed
     * @throws InternalErrorException
     */
    public function getToken()
    {
        $token = JWTAuth::getToken();

        if ( ! $token ) {
            throw new MethodNotAllowedException([], 'Token is not provided');
        }

        try {
            $refreshedToken = JWTAuth::refresh($token);
        } catch (JWTException $e) {
            throw new InternalErrorException( 'Not able to refresh Token' );
        }

        return $this->response->withArray( ['token' => $refreshedToken] );
    }
}

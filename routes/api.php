<?php

use Illuminate\Http\Request;
use Dingo\Api\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/** @var Router $api */
$api = app(Router::class);
$api->group([
    'version' => 'v1',
    'namespace' => 'App\Http\Controllers\Api',
], function (Router $api){

    /*
    |------------------------------
    | Protected Routes
    |------------------------------
    |
    */
    $api->group(['middleware' => 'api.auth'], function(Router $api){

        // Authentication
        $api->get('authenticated_user', 'AuthenticateController@authenticatedUser')->name('api.authenticated_user');

        // Users
        $api->put( 'users/{user}', 'UserController@update' )->where( 'user', '[0-9]+' )->name( 'api.users.update' );
        $api->delete( 'users/{user}', 'UserController@destroy' )->where( 'user', '[0-9]+' )->name( 'api.users.destroy' );
    });

    /*
    |------------------------------
    | Non-Protected Routes
    |------------------------------
    |
    */
    // Authentication
    $api->post('authenticate', 'AuthenticateController@authenticate')->name('api.authenticate');
    $api->post('logout',       'AuthenticateController@logout')->name('api.logout');
    $api->get('token',         'AuthenticateController@getToken')->name('api.token');

    // Users
    $api->get( 'users', 'UserController@index' )->name( 'api.users.list' );
    $api->get( 'users/{user}', 'UserController@show' )->where( 'user', '[0-9]+' )->name( 'api.users.show' );
    $api->post( 'users', 'UserController@store' )->name( 'api.users.store' );

});

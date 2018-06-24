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
$api->version('v1', [], function (Router $api) {

    $api->group([
        'namespace' => 'App\Http\Controllers\Api',
    ], function (Router $api){

        $api->resource('users', 'UserController');

    });

});

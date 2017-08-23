<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});

Route::get('/redirect', function () {
  $query = http_build_query([
    'client_id' => 'client-id',
    'redirect_uri' => 'http://example.com/callback',
    'response_type' => 'code',
    'scope' => '',
  ]);

});

  Route::group(['namespace' => 'Api'], function () {
    Route::post('/login', 'UserController@login');
  });

  Route::group(['middleware' => 'auth:api', 'namespace' => 'api'], function() {
    Route::get('details', 'UserController@details');
  });

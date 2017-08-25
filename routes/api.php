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

  Route::group(['namespace' => 'Api'], function () {
    // Route::post('/login', 'UserController@login');
    Route::resource('users', 'UsersController');
  });

  Route::group(['middleware' => 'auth:api', 'namespace' => 'api'], function() {
    Route::get('details', 'UserController@details');
  });

Route::get('/redirect', function () {
    $query = http_build_query([
        'client_id' => 'client-id',
        'redirect_uri' => 'http://example.com/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);

    return redirect('http://deal.app/oauth/authorize?'.$query);
});


  Route::get('/callback', function (Request $request) {
    $http = new GuzzleHttp\Client;

    $response = $http->post('http://deal.app/oauth/token', [
      'form_params' => [
        'grant_type' => 'authorization_code',
        'client_id' => 'client-id',
        'client_secret' => 'client-secret',
        'redirect_uri' => 'http://example.com/callback',
        'code' => $request->code,
      ],
    ]);

    return json_decode((string) $response->getBody(), true);
  });

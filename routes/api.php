<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group([
  'prefix' => 'auth'
], function () {
  Route::post('login', 'AuthController@login');
  Route::post('signup', 'AuthController@signup');
});

Route::group([
  'prefix' => 'router',
  'middleware' => [ 'auth:api' ]
], function () {
  Route::get('/', 'ApiController@index');
  Route::post('/update/ip', 'ApiController@updateByIp');
  Route::post('/fetch/sapip', 'ApiController@getBySapId');
  Route::post('/delete/ip', 'ApiController@deleteByIp');
  Route::post('/fetch/iprange', 'ApiController@getByIpRange');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

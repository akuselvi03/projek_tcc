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

Route::post('register', 'Api\AuthController@register');
Route::post('login','Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('user','Api\AuthController@index');
    Route::get('user/{id}','Api\AuthController@getUser');
    Route::put('user/{id}','Api\AuthController@update');
    Route::delete('user/{id}','Api\AuthController@destroy');
    Route::get('guest','Api\GuestController@index');
    Route::get('guest/{id}','Api\GuestController@show');
    Route::post('guest','Api\GuestController@store');
    Route::put('guest/{id}','Api\GuestController@update');
    Route::delete('guest/{id}','Api\GuestController@destroy');
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

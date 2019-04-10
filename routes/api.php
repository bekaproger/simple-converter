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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::apiResource('currencies', 'CurrencyController')->middleware('jwt');

Route::namespace('Api\Auth')->group(function(){
	Route::post('login', 'AuthController@login');
	Route::post('logout', 'AuthController@logout')->middleware('jwt');
	Route::post('register', 'AuthController@register');
});
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

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:api');


Route::group(['middleware' => ['authapi']], function () {
    # Admin
    Route::group(['middleware' => ['\App\Http\Middleware\AdminPrivilegeMiddleware']], function () {
        Route::resource('user', 'UsersController', ['only' => [
            'store', 'destroy', 'update'
        ]]);
    });

    # Kurir
    Route::group(['middleware' => ['\App\Http\Middleware\LoggedPrivilegeMiddleware']], function () {
        Route::resource('user', 'UsersController', ['only' => [
            'index'
        ]]);
    });

    Route::resource('/auth/token', 'AuthController', ['only' => [
        'store', 'show'
    ]]);

    Route::post('/auth/token/password', ['as' => 'auth.token.grantpassword', 'uses' => 'AuthController@grantpassword']);
    Route::post('/auth/token/passwordhashed', ['as' => 'auth.token.grantpasswordhashed', 'uses' => 'AuthController@grantpasswordhashed']);
    Route::put('/auth/token/refresh', ['as' => 'auth.token.refresh', 'uses' => 'AuthController@refresh']);

});
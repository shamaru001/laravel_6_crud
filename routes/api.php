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

//Resources protected
Route::middleware(['auth:api'])->group(function () {
    Route::resource('users', "UserController")->except([
        'store'
    ]);
});

////////PUBLIC ENDPOINTS //////////////////

//Register
Route::resource('users', "UserController")->except([
    'update', 'destroy', 'show', 'index'
]);

//Sign in
Route::post('auth', 'ApiTokenController@getToken');





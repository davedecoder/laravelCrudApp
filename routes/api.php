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

Route::get('/states', 'States@getAll');
Route::get('/clients/{id?}', 'Clients@index');
Route::post('/clients', 'Clients@store');
Route::post('/clients/{id}', 'Clients@update');
Route::delete('/clients/{id}', 'Clients@destroy');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return new \App\Http\Resources\User\UserResource($request->user());
});

Route::group(['namespace' => 'App\Http\Controllers\Api', 'middleware' => 'auth:sanctum'], function (){
    Route::post('store', 'TaskController@store');
    Route::get('', 'TaskController@index');
    Route::get('/{id}', 'TaskController@show');
    Route::put('/{id}', 'TaskController@update');
    Route::delete('/{id}', 'TaskController@destroy');
});

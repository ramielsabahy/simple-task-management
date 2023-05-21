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

Route::group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers\Api'], function (){
    Route::post('login', 'UsersController@login');
    Route::post('register', 'UsersController@register');
    Route::get('profile', 'UserProfileController@profile')->middleware('auth:sanctum');
});

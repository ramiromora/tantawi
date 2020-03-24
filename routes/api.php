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
Route::post('department', 'Api\UserController@department');

Route::post('cargo', 'Api\UserController@cargo')->name('cargo');
Route::post('comite', 'Api\UserController@comite')->name('comite');

Route::post('nueva', 'Api\OrderController@store')->name('nueva');
Route::put('edita', 'Api\OrderController@update')->name('edita');

Route::get('firmar/{user_id}/acta/{act_id}/token/{token}','Api\SignatureController@firmar')->name('firmar');
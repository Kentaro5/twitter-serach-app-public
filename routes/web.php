<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/auth/redirect/{provider}', 'Auth\TwitterAuthController@redirect');
Route::get('/auth/callback/{provider}', 'Auth\TwitterAuthController@callback');
Route::get('/auth/testcallback/{provider}', 'Auth\TwitterAuthController@test_callback');

Route::get('/{any?}', function () {
    return view('index');
})->where('any', '.+');


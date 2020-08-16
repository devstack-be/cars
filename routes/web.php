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

Route::get('/', [
    'uses'  => 'HomeController@index',
    'as'    => 'home'
]);

Route::post('/upload', [
    'uses'  => 'HomeController@upload',
    'as'    => 'upload'
]);

Route::get('/plates', [
    'uses'  => 'HomeController@plates',
    'as'    => 'plates'
]);

Route::post('/verify', [
    'uses'  => 'HomeController@verify',
    'as'    => 'verify'
]);
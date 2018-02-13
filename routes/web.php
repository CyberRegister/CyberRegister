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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group([ 'middleware' => 'auth'], function () {
    Route::resource('users', 'UserController');
    Route::resource('user/{user}/pce-points', 'PcePointController');
    Route::resource('user/{user}/expertise', 'ExpertiseController');
    Route::resource('cyber', 'CyberExpertiseController');
});
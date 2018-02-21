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
Route::get('/logout', 'HomeController@logout')->name('logout');

Route::group([ 'middleware' => 'auth'], function () {
    Route::post('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');
    Route::resource('pcePoint', 'PcePointController');
    Route::resource('expertise', 'ExpertiseController');
    Route::resource('cyberExpertise', 'CyberExpertiseController');
});
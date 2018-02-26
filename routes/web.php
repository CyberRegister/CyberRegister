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

Route::group(['middleware' => 'auth'], function () {
    Route::post('users/search', 'UserController@search')->name('users.search');
    Route::resource('users', 'UserController');
    Route::resource('pcePoint', 'PcePointController');
    Route::resource('expertise', 'ExpertiseController');
    Route::resource('cyberExpertise', 'CyberExpertiseController');
    Route::get('/u2f/register', '\Lahaxearnaud\U2f\Http\Controllers\U2fController@registerData')->name('u2f.register.data');
    Route::post('/u2f/register', '\Lahaxearnaud\U2f\Http\Controllers\U2fController@register')->name('u2f.register');
    Route::get('/u2f/auth', '\Lahaxearnaud\U2f\Http\Controllers\U2fController@authData')->name('u2f.auth.data');
    Route::post('/u2f/auth', '\Lahaxearnaud\U2f\Http\Controllers\U2fController@auth')->name('u2f.auth');
});
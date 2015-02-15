<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', [
  'as' => 'home',
  'uses' => 'HomeController@index'
]);

/**
 * User
 */

Route::get('/register', [
  'as' => 'register',
  'uses' => 'UsersController@create'
]);

Route::get('/user', [
  'as' => 'user-index',
  'uses' => 'UsersController@index'
]);

Route::get('user/{id}', [
  'as' => 'user-show',
  'uses' => 'UsersController@show'
]);

/**
 * Session
 */

Route::get('/login', [
  'as' => 'login',
  'uses' => 'SessionsController@create'
]);
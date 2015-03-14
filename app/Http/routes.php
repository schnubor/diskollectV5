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
  'uses' => 'UsersController@create',
  'middleware' => 'guest'
]);

Route::post('/register', [
  'as' => 'post.register',
  'uses' => 'UsersController@store',
  'middleware' => 'guest'
]);

Route::get('/user', [
  'as' => 'user.index',
  'uses' => 'UsersController@index'
]);

Route::get('/user/edit', [
  'as' => 'get.edit.user',
  'uses' => 'UsersController@edit',
  'middleware' => 'auth'
]);

Route::post('/user/edit', [
  'as' => 'post.edit.user',
  'uses' => 'UsersController@update',
  'middleware' => 'auth'
]);

Route::get('/user/{id}', [
  'as' => 'user.show',
  'uses' => 'UsersController@show'
]);

Route::get('/activate/{code}', [
  'as' => 'user.activate',
  'uses' => 'UsersController@activate'
]);

Route::get('/password/email', [
  'as' => 'password',
  'uses' => 'UsersController@getPassword',
  'middleware' => 'guest'
]);

Route::post('/password/email', [
  'as' => 'post.password',
  'uses' => 'UsersController@postPassword',
  'middleware' => 'guest'
]);

Route::get('/password/recover/{code}', [
  'as' => 'recover',
  'uses' => 'UsersController@recover',
  'middleware' => 'guest'
]);

Route::get('/password/edit', [
  'as' => 'get.edit.password',
  'uses' => 'UsersController@getEditPassword',
  'middleware' => 'auth'
]);


Route::post('/password/edit', [
  'as' => 'post.edit.password',
  'uses' => 'UsersController@postEditPassword',
  'middleware' => 'auth'
]);

/**
 * Session
 */

Route::get('/login', [
  'as' => 'login',
  'uses' => 'SessionsController@create',
  'middleware' => 'guest'
]);

Route::post('/login', [
  'as' => 'post.login',
  'uses' => 'SessionsController@store',
  'middleware' => 'guest'
]);

Route::get('/logout', [
  'as' => 'get.logout',
  'uses' => 'SessionsController@destroy',
  'middleware' => 'auth'
]);
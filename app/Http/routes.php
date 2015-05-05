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
 * API
 */

Route::get('/api/user/{id}/vinyls', [
  'as' => 'api.user.vinyls',
  'uses' => 'ApiController@vinyls'
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

Route::get('/collectors', [
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

Route::get('/user/{id}/collection', [
  'as' => 'user.collection',
  'uses' => 'UsersController@collection'
]);

Route::get('/user/{id}/jukebox', [
  'as' => 'user.jukebox',
  'uses' => 'UsersController@jukebox'
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
 * Vinyls
 */

Route::get('/search', [
  'as' => 'get.search',
  'uses' => 'VinylsController@search',
  'middleware' => 'auth'
]);

Route::post('/search', [
  'as' => 'post.search',
  'uses' => 'VinylsController@result',
  'middleware' => 'auth'
]);

Route::get('/vinyl/create', [
  'as' => 'get.create.vinyl',
  'uses' => 'VinylsController@create',
  'middleware' => 'auth'
]);

Route::post('/vinyl/create', [
  'as' => 'post.create.vinyl',
  'uses' => 'VinylsController@store',
  'middleware' => 'auth'
]);

Route::get('/vinyl/add', [
  'as' => 'get.add.vinyl',
  'uses' => 'VinylsController@add',
  'middleware' => 'auth'
]);

Route::get('/vinyl/{id}', [
  'as' => 'get.show.vinyl',
  'uses' => 'VinylsController@show'
]);

Route::get('/vinyl/{id}/edit', [
  'as' => 'get.edit.vinyl',
  'uses' => 'VinylsController@edit',
  'middleware' => 'auth'
]);

Route::post('/vinyl/{id}/edit', [
  'as' => 'post.edit.vinyl',
  'uses' => 'VinylsController@update',
  'middleware' => 'auth'
]);

Route::delete('/vinyl/{id}/delete', [
  'as' => 'delete.vinyl',
  'uses' => 'VinylsController@destroy',
  'middleware' => 'auth'
]);

/*
| Discogs oAuth
*/

Route::get('oauth/discogs', array(
  'as' => 'get.oAuthDiscogs',
  'uses' => 'VinylsController@oAuthDiscogs'
));

/**
 * Follows
 */

Route::post('/follow', [
  'as' => 'follow',
  'uses' => 'FollowsController@store',
  'middleware' => 'auth'
]);

Route::delete('/unfollow/{id}', [
  'as' => 'unfollow',
  'uses' => 'FollowsController@destroy',
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
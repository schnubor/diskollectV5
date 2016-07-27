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

Route::get('/mailtest', function(){
  return view('emails.follow');
});

Route::get('/', [
  'as' => 'home',
  'uses' => 'HomeController@index'
]);

/**
 * API
 */

 Route::get('/api/user/me', [
   'as' => 'api.user.me',
   'uses' => 'ApiController@me'
 ]);

Route::get('/api/user/{id}/vinyls', [
  'as' => 'api.user.vinyls',
  'uses' => 'ApiController@vinyls'
]);

Route::get('/api/user/{id}/vinyls/all', [
  'as' => 'api.user.vinyls.all',
  'uses' => 'ApiController@vinylsAll'
]);

Route::get('/api/user/{id}/vinyls/videos/all', [
  'as' => 'api.user.vinyls.videos.all',
  'uses' => 'ApiController@vinylsWithVideosAll'
]);

Route::get('/api/user/{id}/status', [
  'as' => 'api.user.status',
  'uses' => 'ApiController@connectionStatus'
]);

Route::get('/api/vinyl/{id}/videos', [
  'as' => 'api.vinyl.videos',
  'uses' => 'ApiController@videos'
]);

Route::get('/api/vinyl/{id}/tracks', [
  'as' => 'api.vinyl.tracks',
  'uses' => 'ApiController@tracks'
]);

Route::get('/api/discogs/{id}', [
    'as' => 'api.discogs',
    'uses' => 'ApiController@getDiscogsId'
]);

Route::get('/api/discogs/marketplace/{id}', [
    'as' => 'api.discogs.marketplace',
    'uses' => 'ApiController@getDiscogsMarketplaceId'
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

Route::delete('/user/{id}/collection', [
  'as' => 'user.collection.delete',
  'uses' => 'UsersController@deleteCollection',
  'middleware' => 'auth'
]);

Route::get('/user/{id}/jukebox', [
  'as' => 'user.jukebox',
  'uses' => 'UsersController@jukebox'
]);

Route::get('/user/{id}/followers', [
  'as' => 'user.followers',
  'uses' => 'UsersController@followers'
]);

Route::get('/user/{id}/following', [
  'as' => 'user.following',
  'uses' => 'UsersController@following'
]);

Route::get('/settings', [
  'as' => 'user.settings',
  'uses' => 'UsersController@settings',
  'middleware' => 'auth'
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

Route::post('/password/edit', [
  'as' => 'post.edit.password',
  'uses' => 'UsersController@postEditPassword',
  'middleware' => 'auth'
]);

Route::post('/notifications/edit', [
  'as' => 'post.edit.notifications',
  'uses' => 'UsersController@postEditNotifications',
  'middleware' => 'auth'
]);

Route::post('/privacy/edit', [
  'as' => 'post.edit.privacy',
  'uses' => 'UsersController@postEditPrivacy',
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

Route::get('/vinyl/import', [
  'as' => 'get.import.vinyl',
  'uses' => 'VinylsController@import',
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

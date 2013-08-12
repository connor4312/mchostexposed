<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function() {
	return View::make('standard')->
		with('title', 'Home')->
		nest('content', 'pages.home');
});
Route::get('/about', function() {
	return View::make('standard')->
		with('title', 'About')->
		nest('content', 'pages.about');
});
Route::any('/admin', function() {
	return Redirect::to('http://meatspin.com');
});

Route::any('/list', 'ListController@index');
Route::any('/list/autocomplete', 'ListController@autoComplete');

Route::get('/request', 'RequestController@index');
Route::post('/request', 'RequestController@submit');

Route::any('/host/{slug}', 'HostController@index')->where('slug', '[a-z0-9\-]+');
Route::any('/host/{slug}/breakdown', 'HostController@breakdown')->where('slug', '[a-z0-9\-]+');

Route::get('/host/{slug}/report', 'HostController@reportForm')->where('slug', '[a-z0-9\-]+');
Route::post('/host/{slug}/report', 'HostController@reportSubmit')->where('slug', '[a-z0-9\-]+');

Route::any('/admincp', 'AdminController@index');
Route::any('/admincp/login', 'AdminController@login');
Route::any('/admincp/dologin', 'AdminController@doLogin');
Route::any('/admincp/correction/{id}', 'AdminController@showCorrectionRequest');
Route::any('/admincp/review/{id}', 'AdminController@showReviewRequest');
Route::any('/admincp/host/{id}', 'AdminHostController@showHost');
Route::get('/admincp/host', 'AdminHostController@showHost');
Route::post('/admincp/host', 'AdminHostController@addHostSubmit');
<?php

Route::get('/', 'Auth\LoginController@index');

Route::group(['prefix' => 'auth'], function () {
	Route::get('login', 'Auth\LoginController@oAuth');
	Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix' => 'api'], function () {
	Route::resource('user', 'Api\UserController');
});


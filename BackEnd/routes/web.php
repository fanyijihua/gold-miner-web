<?php

Route::get('/', 'Auth\LoginController@index');
Route::get('/joinus', 'Auth\LoginController@index');

Route::group(['prefix' => 'auth'], function () {
	Route::get('login', 'Auth\LoginController@oAuth');
	Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::resource('user', 'UserController');	
	Route::resource('article', 'ArticleController');
	Route::get('checkApplicantEmail/{email}', 'ApplicantController@checkApplicantEmail');
});
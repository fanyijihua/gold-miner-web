<?php

Route::get('/', 'Auth\LoginController@index');

Route::group(['prefix' => 'auth'], function () {
	Route::get('login', 'Auth\LoginController@oAuth');
	Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::put('recommends/result/{id}/{result}', 'RecommendController@result');
	Route::get('applicants/checkEmail/{email}', 'ApplicantController@checkEmail');
	Route::get('articles/random/{category}', 'ArticleController@getRandomArticle');
	Route::resource('users', 'UserController');	
	Route::resource('articles', 'ArticleController');
	Route::resource('categories', 'CategoryController');
	Route::resource('applicants', 'ApplicantController');
	Route::resource('recommends', 'RecommendController');
	Route::resource('notifications', 'NotificationController');
});
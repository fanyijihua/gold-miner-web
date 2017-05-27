<?php

Route::get('/', 'Auth\LoginController@index');
Route::get('/joinus', 'Auth\LoginController@index');

Route::group(['prefix' => 'auth'], function () {
	Route::get('login', 'Auth\LoginController@oAuth');
	Route::get('logout', 'Auth\LoginController@logout');
});

Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::get('applicant/getUndoNum', 'ApplicantController@getUndoNum');
	Route::get('applicant/checkEmail/{email}', 'ApplicantController@checkEmail');
	Route::get('article/updateStatus/{id}', 'ArticleController@updateStatus');
	Route::get('article/random/{category}', 'ArticleController@getRandomArticle');
	Route::resource('user', 'UserController');	
	Route::resource('article', 'ArticleController');
	Route::resource('applicant', 'ApplicantController');
});
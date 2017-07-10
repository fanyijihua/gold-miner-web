<?php
// 身份验证
Route::group(['prefix' => 'auth'], function () {
	Route::get('login', 'Auth\LoginController@oAuth');
	Route::get('logout', 'Auth\LoginController@logout');
});

// API 接口
Route::group(['prefix' => 'api', 'namespace' => 'Api'], function () {
	Route::get('articles/random/{category}', 'ArticleController@getRandomArticle');
	Route::group(['middleware' => 'token'], function () {
		Route::put('articles/status/{id}', 'ArticleController@updateStatus');
		Route::put('recommends/result/{id}/{result}', 'RecommendController@result');
		Route::resource('users', 'UserController');
		Route::resource('articles', 'ArticleController');
		Route::resource('categories', 'CategoryController');
		Route::resource('applicants', 'ApplicantController');
		Route::resource('recommends', 'RecommendController');
		Route::resource('notifications', 'NotificationController');
	});
});

// 匹配其他路由
Route::any('{uri}', function($uri)
{
	return view('index', ['user'=>'']);
})->where('uri', '.*?');
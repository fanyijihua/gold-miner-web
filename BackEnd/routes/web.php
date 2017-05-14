<?php

Route::get('/', 'Auth\LoginController@index');

Route::get('/auth/login', 'Auth\LoginController@oAuth');

Route::resource('/api/user', 'Api\UserController');

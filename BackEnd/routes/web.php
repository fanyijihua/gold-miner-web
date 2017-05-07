<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/auth/login', 'Auth\LoginController@oAuth');

Route::resource('/api/user', 'Api\UserController');

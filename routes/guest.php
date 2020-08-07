<?php 

Route::get('register', 'RegisterController@create')->name('register');

Route::post('register', 'RegisterController@store');

Route::get('register-confirmation', 'RegisterController@confirmation');

Route::get('login', 'TokenController@create')->name('token');

Route::post('login', 'TokenController@store');

Route::get('login/{token}', 'LoginController@login')->name('login');


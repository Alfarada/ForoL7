<?php 

Route::get('register', 'RegisterController@create')->name('register');

Route::post('register', 'RegisterController@store');

Route::get('login', 'LoginController@create')->name('login');

Route::post('login', 'LoginController@store');

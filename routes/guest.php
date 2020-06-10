<?php 

Route::get('register', 'RegisterController@create')->name('register');

Route::post('register', 'RegisterController@store');
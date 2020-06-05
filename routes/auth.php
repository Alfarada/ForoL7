<?php

//Rutas que requieren autenticacion

//Posts
Route::get('posts/create', 'PostController@create')->name('posts.create');

Route::post('posts/create', 'PostController@store')->name('posts.store');
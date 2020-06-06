<?php

//Rutas que requieren autenticacion

//Posts
Route::get('posts/create', 'CreatePostController@create')->name('posts.create');

Route::post('posts/create', 'CreatePostController@store')->name('posts.store');

//Comments

Route::post('posts/{post}/comment', 'CommentController@store')->name('comments.store');
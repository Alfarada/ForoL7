<?php

//Rutas que requieren autenticacion

//Posts
Route::get('posts/create', 'CreatePostController@create')
    ->name('posts.create');

Route::post('posts/create', 'CreatePostController@store')
    ->name('posts.store');

//Comments
Route::post('posts/{post}/comment', 'CommentController@store')
    ->name('comments.store');

Route::post('comments/{comment}/accept', 'CommentController@accept')
    ->name('comments.accept');

//Subscribe

Route::post('post/{post}/subscribe', 'SubscriptionController@subscribe')
    ->name('posts.subscribe');

Route::delete('post/{post}/subscribe', 'SubscriptionController@unsubscribe')
    ->name('posts.unsubscribe');

Route::get('mis-posts/{category?}', 'ListPostController')
    ->name('posts.mine');

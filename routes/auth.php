<?php

//Rutas que requieren autenticacion

//Posts
Route::get('posts/create', 'CreatePostController@create')
    ->name('posts.create');

Route::post('posts/create', 'CreatePostController@store')
    ->name('posts.store');

// Votes
Route::post('/posts/{post}/vote/1', 'VotePostController@upvote')
    ->where('post', '\d+');

Route::post('/posts/{post}/vote/-1', 'VotePostController@downvote')
    ->where('post', '\d+');

Route::delete('/posts/{post}/vote', 'VotePostController@undoVote')
->where('post', '\d+');

// Comments
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

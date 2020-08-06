<?php

//Rutas que requieren autenticacion

//Posts
Route::get('posts/create', 'CreatePostController@create')
    ->name('posts.create');

Route::post('posts/create', 'CreatePostController@store')
    ->name('posts.store');

// Votes - posts
Route::post('/posts/{post}/vote/1', 'VotePostController@upvote');

Route::post('/posts/{post}/vote/-1', 'VotePostController@downvote');

Route::delete('/posts/{post}/vote', 'VotePostController@undoVote');

// Votes - comments
Route::post('/comments/{comment}/vote/1', 'VoteCommentController@upvote'); 

Route::post('/comments/{comment}/vote/-1', 'VoteCommentController@downvote');

Route::delete('/comments/{comment}/vote', 'VoteCommentController@undoVote');


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

<?php


use App\{Post,Comment};

// Rutas que requieren autenticacion

// Logout

Route::post('logout', 'LoginController@logout');

Route::get('posts/create', 'CreatePostController@create')
    ->name('posts.create');

Route::post('posts/create', 'CreatePostController@store')
    ->name('posts.store');

// Votes - posts

Route::pattern('module', '[a-z]+');

Route::bind('votable', function ($votableId, $route) {

    $modules = [
        'posts' => Post::class,
        'comments' => Comment::class
    ];

    $model = $modules[$route->parameter('module')] ?? null;

    abort_unless($model, 404);

    return $model::findOrFail($votableId);

    //return

    // switch ($route->parameter('module')) {
    //     case 'posts':
    //         return Post::findOrFail($votableId);
    //         break;      
    //     case 'comments':
    //         return Comment::findOrFail($votableId);
    //         break;
    //     default:
    //         abort(404);
    //         break;
    // }
});

Route::post('/{module}/{votable}/vote/1', 'VoteController@upvote');

Route::post('/{module}/{votable}/vote/-1', 'VoteController@downvote');

Route::delete('/{module}/{votable}/vote', 'VoteController@undoVote');

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

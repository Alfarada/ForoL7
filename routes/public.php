<?php

use App\Post;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/home', 'HomeController@index')
    ->name('home');

//Show posts
Route::get('/posts/{post}-{slug}', 'ShowPostController')
    ->name('posts.show')
    ->where('post', '\d+');

Route::get('posts-pendientes/{category?}', 'ListPostController')
    ->name('posts.pending');

Route::get('posts-completados/{category?}', 'ListPostController')
    ->name('posts.completed');

Route::get('{category?}', 'ListPostController')
    ->name('posts.index');
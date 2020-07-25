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

Route::get('/home', 'HomeController@index')->name('home');

//Show posts
Route::get('/posts/{post}-{slug}', 'PostShowController@show')
->name('posts.show')
->where('post', '\d+');

Route::get('posts-completados', 'PostShowController@index')->name('posts.completed');

Route::get('posts-pendientes', 'PostShowController@index')->name('posts.pending');

Route::get('posts-pendientes/{category?}', [
    'uses' => 'PostShowController@index',
    'as' => 'posts.pending'
]);

Route::get('posts-completados/{category?}', [
    'uses' => 'PostShowController@index',
    'as' => 'posts.completed'
]);


Route::get('{category?}', 'PostShowController@index')->name('posts.index');
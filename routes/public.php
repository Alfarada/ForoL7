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

Route::get('/', 'PostShowController@index')->name('posts.index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Show posts
Route::get('/posts/{post}-{slug}', 'PostShowController@show')
    ->name('posts.show')
    ->where('post', '\d+');

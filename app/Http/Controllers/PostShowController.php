<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostShowController extends Controller
{
    public function show( Post $post)
    {
        return view('posts.show', ['post' => $post]);
    }
}

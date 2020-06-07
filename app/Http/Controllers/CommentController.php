<?php

namespace App\Http\Controllers;

use App\{Post, Comment};
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request,Post $post)
    {
         auth()->user()->comment($request->get('comment'), $post);

         return redirect($post->url);
    }

    public function accept(Comment $comment)
    {
        $comment->markAsAnswer();
        
        return  redirect($comment->post->url);
    }
}

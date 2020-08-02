<?php

namespace App\Http\Controllers;

use App\{Post,Vote};

class VotePostController extends Controller
{
    function upvote(Post $post)
    {
        $post->upvote();

        return [
            'new_score' => $post->score
        ];

    }

    function downvote(Post $post)
    {   
        $post->downvote();

        return [
            'new_score' => $post->score
        ];

    }
    
    function undoVote(Post $post)
    {   
        $post->undoVote();
        
        return [
            'new_score' => $post->score
        ];

    }
}

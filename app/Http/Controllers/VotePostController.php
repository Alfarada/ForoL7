<?php

namespace App\Http\Controllers;

use App\{Post,Vote};

class VotePostController extends Controller
{
    function upvote(Post $post)
    {
        Vote::upvote($post);

        return [
            'new_score' => $post->score
        ];

    }

    function downvote(Post $post)
    {
        Vote::downvote($post);

        return [
            'new_score' => $post->score
        ];

    }
    
    function undoVote(Post $post)
    {
        Vote::undoVote($post);

        return [
            'new_score' => $post->score
        ];

    }
}

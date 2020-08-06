<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class VoteCommentController extends Controller
{
    function upvote(Comment $comment)
    {
        $comment->upvote();

        return [
            'new_score' => $comment->score
        ];

    }

    function downvote(Comment $comment)
    {   
        $comment->downvote();

        return [
            'new_score' => $comment->score
        ];

    }
    
    function undoVote(Comment $comment)
    {   
        $comment->undoVote();

        return [
            'new_score' => $comment->score
        ];

    }
}

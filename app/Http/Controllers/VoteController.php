<?php

namespace App\Http\Controllers;

class VoteController extends Controller
{
    function upvote($module, $votable)
    {   
        $votable->upvote();

        return [
            'new_score' => $votable->score
        ];

    }

    function downvote($module, $votable)
    {   
        $votable->downvote();

        return [
            'new_score' => $votable->score
        ];

    }
    
    function undoVote($module, $votable)
    {   
        $votable->undoVote();

        return [
            'new_score' => $votable->score
        ];

    }
}

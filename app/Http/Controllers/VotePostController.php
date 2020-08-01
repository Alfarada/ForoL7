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
}

<?php

namespace App\Http\Controllers;

use App\Post;
use App\VoteRepository;

class VotePostController extends Controller
{   
    private $voteRepository;

    public function __construct(VoteRepository $voteRepository)
    {
        $this->voteRepository = $voteRepository;
    }

    function upvote(Post $post)
    {
        $this->voteRepository->upvote($post);

        return [
            'new_score' => $post->score
        ];
    }

    function downvote(Post $post)
    {
        $this->voteRepository->downvote($post);

        return [
            'new_score' => $post->score
        ];
    }
    
    function undoVote(Post $post)
    {
        $this->voteRepository->undoVote($post);

        return [
            'new_score' => $post->score
        ];
    }
}

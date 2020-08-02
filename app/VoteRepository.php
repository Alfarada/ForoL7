<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VoteRepository extends Model
{    
    public  function upvote(Post $post)
    {
        $this->addVotes($post, 1);
    }

    public  function downvote(Post $post)
    {
        $this->addVotes($post, -1);
    }

    protected  function addVotes(Post $post, $amount)
    {
        Vote::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => auth()->id()],
            ['vote' => $amount]
        );

        $this->refreshPostScore($post);
    }

    public  function undoVote(Post $post)
    {
        Vote::where([
            'post_id' => $post->id,
            'user_id' => auth()->id()
        ])->delete();

        $this->refreshPostScore($post);
    }

    protected  function refreshPostScore(Post $post)
    {
        $post->score = Vote::where(['post_id' => $post->id])->sum('vote');
        $post->save();
    }
}

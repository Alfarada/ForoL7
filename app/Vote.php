<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{   
    protected $guarded = [];

    public static function upvote(Post $post)
    {   
        static::addVotes($post, 1);
    }

    public static function downvote(Post $post)
    {    
         static::addVotes($post,-1);
    }

    public static function addVotes(Post $post, $amount)
    {
        static::updateOrCreate(
            ['post_id' => $post->id, 'user_id' => auth()->id()],
            ['vote' => $amount]);

        $post->score = $amount;
        $post->save();
    }
}

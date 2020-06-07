<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{   
    protected $fillable = ['post_id', 'user_id', 'comment'];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function markAsAnswer()
    {   
        $this->post->pending = false;
        $this->post->answer_id = $this->id;

        $this->post->save();
    }

    public function getAnswerAttribute()
    {
        return $this->id === $this->post->answer_id;
    }
}

<?php

namespace App;

use App\CanBeVoted;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{   
    use CanBeVoted;

    protected $fillable = ['post_id', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

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

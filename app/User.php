<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function subscriptions()
    {
        return $this->belongsToMany(Post::class, 'subscriptions');
    }

    public function createPost(array $data)
    {
        $post = new Post($data);
        
        $this->posts()->save($post);
        $this->subscribeTo($post);

        return $post;
    }

    public function comment($message, Post $post)
    {
        $comment = new Comment([
            'comment' => $message,
            'post_id' => $post->id
        ]);

        $this->comments()->save($comment);
    }

    public function owns(Model $model)
    {
        return $this->id === $model->user_id;
    }

    public function subscribeTo(Post $post)
    {
        $this->subscriptions()->attach($post);
    }

    public function unsubscribeFrom(Post $post)
    {
        $this->subscriptions()->detach($post);
    }

    public function isSubscribedTo(Post $post)
    {
        return $this->subscriptions()->where('post_id',$post->id)->count() > 0;
    }

}

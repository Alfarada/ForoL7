<?php

namespace Tests\Feature;

use App\Comment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class MarkCommentAsAnswerTest extends TestCase
{   
    use DatabaseTransactions;

    //Un post puede ser respondido
    function test_a_post_can_be_answered()
    {
        $post = $this->createPost();

        $comment = factory(Comment::class)->create([
            'post_id' => $post->id
        ]);

        $comment->markAsAnswer();
        
        //dd($comment->answer);

        $this->assertTrue($comment->fresh()->answer);
        $this->assertFalse($post->fresh()->pending);
    }

    //Un post solo puede tener una unica respuesta
    function test_a_post_can_only_have_one_answered()
    {
        $post = $this->createPost();

        $comments = factory(Comment::class)->times(2)->create([
            'post_id' => $post->id
        ]);

        $comments->first()->markAsAnswer();
        $comments->last()->markAsAnswer();

        $this->assertFalse($comments->first()->fresh()->answer);
        $this->assertTrue($comments->last()->fresh()->answer);
    }
}

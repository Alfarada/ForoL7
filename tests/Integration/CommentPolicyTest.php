<?php

namespace Tests\Integrations;

use App\{User, Comment};
use App\Policies\CommentPolicy;
use Tests\TestCase;

class CommentPolicyTest extends TestCase
{   

    //El autor del post puede seleccionar un comentario como una respuesta
    public function test_the_post_select_a_comment_as_an_answer()
    {   
        $comment = factory(Comment::class)->create();
        
        $policy = new CommentPolicy;

        $this->assertTrue($policy->accept($comment->post->user, $comment)); 
    }

    //Usuarios que no son autores no pueden seleccionar un comentario como una respuesta
    public function test_non_authors_cannot_select_a_comment_as_an_answer()
    {   
        $comment = factory(Comment::class)->create();
        
        $policy = new CommentPolicy;

        $this->assertFalse($policy->accept(factory(User::class)->create(), $comment)); 
 
    }
}

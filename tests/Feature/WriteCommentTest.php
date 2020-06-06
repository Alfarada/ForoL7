<?php

namespace Tests\Feature;
use Tests\FeatureTestCase;

class WriteCommentTest extends FeatureTestCase
{   
    //Usuario puede escribir un comentario
    function test_a_user_can_write_a_comment()
    {   //Have
        $post = $this->createPost();
        $user = $this->defaultUser([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);
        
        //When
        $this->actingAs($user)
            ->visit($post->url)
            ->type('Un comentario', 'comment')
            ->press('Publicar comentario');
        
        //Then
        $this->seeInDatabase('comments', [
            'comment' => 'Un comentario',
            'user_id' => $user->id,
            'post_id'=> $post->id            
        ]);

        $this->seePageIs($post->url);
    }
}

<?php

namespace Tests\Feature;

use App\Comment;
use App\User;
use Tests\FeatureTestCase;

class AceptAnswerTest extends FeatureTestCase
{
    //El autor del post puede aceptar un comentario como la respuesta del post
    function test_the_posts_author_can_accept_a_comment_as_the_posts_answer()
    {
        $comment = factory(Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $this->visit($comment->post->url)
            ->press('Aceptar respuesta');

        $this->seeInDatabase('posts', [
            'id' => $comment->post_id,
            'pending' => false,
            'answer_id' => $comment->id
        ]);

        $this->seePageIs($comment->post->url)
            ->seeInElement('.answer', $comment->comment);
    }

    //El usuario que no es el autor del post no observa el boton de aceptar respuesta
    function test_the_non_posts_author_dont_see_the_accept_answer_button()
    {
        $comment = factory(Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs(factory(User::class)->create());

        $this->visit($comment->post->url)
            ->dontSee('Aceptar respuesta');
    }

    //El usuario que no es el autor del post no puede aceptar un comentario como respuesta
    function test_the_non_posts_author_cannot_accept_a_comment_as_the_posts_answer()
    {
        $comment = factory(Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs(factory(User::class)->create());

        $this->post(route('comments.accept', $comment));
            
        $this->seeInDatabase('posts', [
            'id' => $comment->post_id,
            'pending' => true,
        ]);
    }

    //El botón aceptar permanece oculto cuando el comentario ya sea la respuesta del post
    function test_the_accept_button_is_hidden_when_the_comment_is_already_the_posts_answer()
    {
        $comment = factory(Comment::class)->create([
            'comment' => 'Esta va a ser la respuesta del post'
        ]);

        $this->actingAs($comment->post->user);

        $comment->markAsAnswer();

        $this->visit($comment->post->url)
            ->dontSee('Aceptar respuesta');
    }
}

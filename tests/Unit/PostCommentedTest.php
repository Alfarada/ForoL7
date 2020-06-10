<?php

namespace Tests\Unit;

use App\{Post,User, Comment};
use App\Notifications\PostCommented;
use Illuminate\Notifications\Messages\MailMessage;
use Tests\FeatureTestCase;

class PostCommentedTest extends FeatureTestCase
{   
    //Comprobando que se construye un mensaje de correo
    public function test_it_builds_a_mail_message()
    {   
        $post = factory(Post::class)->create([
            'title' => 'Titulo del post',
        ]);

        $author = factory(User::class)->create([
            'first_name' => 'Alfredo'
        ]);

        $comment = factory(Comment::class)->create([
            'post_id' => $post->id,
            'user_id' => $author->id

        ]);

        $notification = new PostCommented($comment);

        $subscriber = factory(User::class)->create();

        $message = $notification->toMail($subscriber);

        $this->assertInstanceOf(MailMessage::class, $message);

        $this->assertSame(
            'Nuevo comentario en: Titulo del post',
            $message->subject
        );

        $this->assertSame(
            'Alfredo escribió un comentario en: Titulo del post',
            $message->introLines[0]
        );

        $this->assertSame($comment->post->url,$message->actionUrl); 
    }
}

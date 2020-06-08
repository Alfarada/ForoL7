<?php

namespace Tests\Feature;


use App\User;
use Tests\FeatureTestCase;
use App\Notifications\PostCommented;
use Illuminate\Support\Facades\Notification;


class NotifyUserTest extends FeatureTestCase
{
    public function test_the_subscribers_recive_a_notification_when_post_is_commented()
    {   
        Notification::fake();
        
        $post = $this->createPost();

        $subscriber = factory(User::class)->create();

        $subscriber->subscribeTo($post);

        $writer = factory(User::class)->create();

        $writer->subscribeTo($post);

        $comment = $writer->comment('Un comentario cualquiera',$post);

        Notification::assertSentTo(
            $subscriber, PostCommented::class,function ($notification) use ($comment) {
            return $notification->comment->id == $comment->id;
        });

        //El autor del comentario no deberia ser notificado aun que sea un subscriptor de este post
        Notification::assertNotSentTo($writer, PostCommented::class);
    }
}

<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class SubscribeToPostTest extends FeatureTestCase
{
    public function test_a_user_can_subscribe_to_post()
    {   
        //Having
        $post = $this->createPost();
        $user = $this->defaultUser([]);

        $this->actingAs($user);

        //When
        $this->visit($post->url)
            ->press('Suscribirse al post');

        //Then
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);

        $this->seePageIs($post->url)
            ->dontSee('Suscribirse al post');
    }
}

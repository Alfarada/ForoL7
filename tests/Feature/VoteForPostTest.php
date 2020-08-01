<?php

namespace Tests\Feature;

use Tests\TestCase;

class VoteForPostTest extends TestCase
{   
    //Usuario puede votar por un post
    public function test_a_user_can_be_vote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->post($post->url . '/vote')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 1
            ]);

        $this->assertDatabaseHas('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => 1
        ]);

        $this->assertSame(1, $post->fresh()->score);
    }
}

<?php

namespace Tests\Feature;

use App\Vote;
use Tests\TestCase;

class VoteForPostTest extends TestCase
{   
    //Usuario puede votar por un post
    function test_a_user_can_be_upvote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->post($post->url . '/upvote')
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

    //Usuario puede marcar un voto como como negativo
    function test_a_user_can_be_downvote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->postJson($post->url . '/downvote')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => -1
            ]);

        $this->assertDatabaseHas('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => -1
        ]);

        $this->assertSame(-1, $post->fresh()->score);
    }

    //Usuario puede desvotar un post
    function test_a_user_can_be_unvote_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        Vote::upvote($post);
        
        $this->deleteJson($post->url . '/vote')
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 0
            ]);

        $this->assertDatabaseMissing('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'score' => 0
        ]);

        $this->assertSame(0, $post->fresh()->score);
    }

    //Usuario invitado no puede votar por un post
    function test_a_guest_user_cannot_vote_for_a_post()
    {
        $user = $this->defaultUser();
        $post = $this->createPost();

        $this->postJson("{$post->url}/upvote")
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
 
        $this->assertDatabaseMissing('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'score' => 0
        ]);
    }
}

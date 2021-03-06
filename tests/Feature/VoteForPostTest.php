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

        $this->post("posts/{$post->id}/vote/1")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 1
            ]);

        $this->assertDatabaseHas('votes', [
            'votable_id' => $post->id,
            'votable_type' => \App\Post::class,
            'vote' => 1
        ]);

        $this->assertSame(1, $post->fresh()->score);
    }

    //Usuario puede marcar un voto como como negativo
    function test_a_user_can_be_downvote_for_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $this->postJson("posts/{$post->id}/vote/-1")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => -1
            ]);

        $this->assertDatabaseHas('votes', [
            'votable_id' => $post->id,
            'votable_type' => \App\Post::class,
            'vote' => -1
        ]);

        $this->assertSame(-1, $post->fresh()->score);
    }

    //Usuario puede desvotar un post
    function test_a_user_can_be_unvote_a_post()
    {
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $post->upvote();
        
        $this->deleteJson("posts/{$post->id}/vote")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 0
            ]);

        $this->assertDatabaseMissing('votes', [
            'votable_id' => $post->id,
            'votable_type' => \App\Post::class,
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

        $this->postJson("posts/{$post->id}/vote/1")
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);
 
        $this->assertDatabaseMissing('votes', [
            'votable_id' => $post->id,
            'votable_type' => \App\Post::class,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'score' => 0
        ]);
    }
}

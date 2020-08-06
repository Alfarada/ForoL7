<?php

namespace Tests\Feature;

use Tests\TestCase;

class VoteForCommentTest extends TestCase
{
    function test_a_user_can_upvote_for_a_comment()
    {   
        $this->actingAs($user = $this->defaultUser());

        $comment = $this->createComment();

        $this->postJson("comments/{$comment->id}/vote/1")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 1
            ]);

        $comment->refresh();

        $this->assertSame(1, $comment->current_vote);

        $this->assertSame(1, $comment->score);
    }

    function test_a_user_can_downvote_for_a_comment()
    {   
        $this->actingAs($user = $this->defaultUser());

        $comment = $this->createComment();

        $this->postJson("comments/{$comment->id}/vote/-1")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => -1
            ]);

        $comment->refresh();

        $this->assertSame(-1, $comment->current_vote);

        $this->assertSame(-1, $comment->score);
    }

    function test_a_user_can_unvote_a_comment()
    {   
        $this->actingAs($user = $this->defaultUser());

        $comment = $this->createComment();

        $comment->upvote();

        $this->deleteJson("comments/{$comment->id}/vote/")
            ->assertSuccessful()
            ->assertJson([
                'new_score' => 0
            ]);

        $comment->refresh();

        $this->assertNull($comment->current_vote);

        $this->assertSame(0, $comment->score);
    }

    function test_a_guest_user_cannot_vote_for_a_comment()
    {   
        
        auth()->logout();
        $comment = $this->createComment();

        $this->postJson("comments/{$comment->id}/vote/1")
            ->assertStatus(401)
            ->assertJson(['message' => 'Unauthenticated.']);

        $comment->refresh();

        $this->assertNull($comment->current_vote);

        $this->assertSame(0, $comment->score);
    }
}

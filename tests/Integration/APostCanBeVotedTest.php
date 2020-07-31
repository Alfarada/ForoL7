<?php

use App\Vote;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class APostCanBeVotedTest  extends TestCase
{
    use DatabaseTransactions;

    function test_a_user_can_be_upvoted()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::upvote($post);

        //$this->assertDatabaseHas(); new version 5.4
        $this->seeInDatabase('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => 1
        ]);

        $this->assertSame(1, $post->score);
    }
}

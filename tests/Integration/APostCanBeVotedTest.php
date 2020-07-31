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

    function test_a_user_cannot_be_upvoted_twice_by_the_same_user()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::upvote($post);

        Vote::upvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }


    function test_a_user_can_be_downvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        Vote::downvote($post);

        //$this->assertDatabaseHas(); new version 5.4
        $this->seeInDatabase('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => -1
        ]);

        $this->assertSame(-1, $post->score);
    }

    function test_a_user_cannot_be_downvoted_twice_by_the_same_user()
    {
 
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::downvote($post);

        Vote::downvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    function test_a_user_can_swicth_from_upvote_to_downvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::upvote($post);

        Vote::downvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    
    function test_a_user_can_swicth_from_downvote_to_upvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::downvote($post);

        Vote::upvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }
}

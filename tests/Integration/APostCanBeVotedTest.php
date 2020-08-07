<?php

use App\Vote;
use Tests\TestCase;

class APostCanBeVotedTest  extends TestCase
{
    //Usuario puede sumar un voto 
    function test_a_post_can_be_upvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        $post->upvote();

        $this->assertSame(1, $post->current_vote);

        $this->assertSame(1, $post->score);
    }

    //Usuario no puede sumar votos por el mismo post dos veces
    function test_a_post_cannot_be_upvoted_twice_by_the_same_user()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        $post->upvote();

        $post->upvote();
        
        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }

    //Usuario puede restar un voto
    function test_a_post_can_be_downvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        $post->downvote();

        $this->assertSame(-1, $post->current_vote); // or $post->getVoteFrom($user)

        $this->assertSame(-1, $post->score);
    }

    //Usuario no puede restar votos por el mismo post dos veces
    function test_a_post_cannot_be_downvoted_twice_by_the_same_user()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        $post->downvote();
        
        $post->downvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    //Usuario puede cambiar su voto de positivo a negativo
    function test_a_post_can_swicth_from_upvote_to_downvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        $post->upvote();

        $post->downvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    //Usuario puede cambiar su voto de negativo a positivo
    function test_a_post_can_swicth_from_downvote_to_upvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        $post->downvote();

        $post->upvote();

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }

    //Los puntos de votos en el post sion calculados correctamente
    function test_the_post_score_is_calculated_correctly()
    {   
        
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        $post->votes()->create([
            'user_id' => $this->anyone()->id,
            'vote' => 1
        ]);

        $post->upvote();

        $this->assertSame(2, Vote::count());

        $this->assertSame(2, $post->score);
    }

    //Un post puede ser desmarcado
    function test_a_post_can_be_unvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        $post->upvote();

        $post->undoVote();

        $this->assertNull($post->current_vote);

        $this->assertSame(0, $post->score);
    }

    function test_get_vote_from_user_returns_the_vote_from_right_post()
    {   
        // Having
        $this->actingAs($user = $this->defaultUser());

        $post = $this->createPost();

        $anotherPost = $this->createPost();

        // When
        $post->upvote();
        
        // Then
        $this->assertSame(1, $post->current_vote); // or $post->current_vote

        $this->assertNull($anotherPost->getVoteFrom($user));

    }
}

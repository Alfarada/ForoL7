<?php

use App\{Vote,VoteRepository};
use Tests\TestCase;

class APostCanBeVotedTest  extends TestCase
{
    //Usuario puede sumar un voto 
    function test_a_user_can_be_upvoted()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        app(VoteRepository::class)->upvote($post);

        $this->assertDatabaseHas('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => 1
        ]);

        $this->assertSame(1, $post->score);
    }

    //Usuario no puede sumar votos por el mismo post dos veces
    function test_a_user_cannot_be_upvoted_twice_by_the_same_user()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        app(VoteRepository::class)->upvote($post);

        app(VoteRepository::class)->upvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }

    //Usuario puede restar un voto
    function test_a_user_can_be_downvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        app(VoteRepository::class)->downvote($post);

        $this->assertDatabaseHas('votes', [
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => -1
        ]);

        $this->assertSame(-1, $post->score);
    }

    //Usuario no puede restar votos por el mismo post dos veces
    function test_a_user_cannot_be_downvoted_twice_by_the_same_user()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        app(VoteRepository::class)->downvote($post);

        app(VoteRepository::class)->downvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    //Usuario puede cambiar su voto de positivo a negativo
    function test_a_user_can_swicth_from_upvote_to_downvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        app(VoteRepository::class)->upvote($post);

        app(VoteRepository::class)->downvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(-1, $post->score);
    }

    //Usuario puede cambiar su voto de negativo a positivo
    function test_a_user_can_swicth_from_downvote_to_upvote()
    {
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        app(VoteRepository::class)->downvote($post);

        app(VoteRepository::class)->upvote($post);

        $this->assertSame(1, Vote::count());

        $this->assertSame(1, $post->score);
    }

    //Los puntos de votos en el post sion calculados correctamente
    function test_the_post_score_is_calculated_correctly()
    {   
        
        $user = $this->defaultUser();

        $this->actingAs($user);
        
        $post = $this->createPost();

        Vote::create([
            'post_id' => $post->id,
            'user_id' => $this->anyone()->id,
            'vote' => 1
        ]);

        app(VoteRepository::class)->upvote($post);

        $this->assertSame(2, Vote::count());

        $this->assertSame(2, $post->score);
    }

    //Un post puede ser desmarcado
    function test_a_post_can_be_unvoted()
    {
        $this->actingAs($user = $this->defaultUser());
        
        $post = $this->createPost();

        app(VoteRepository::class)->upvote($post);

        app(VoteRepository::class)->undoVote($post);

        $this->assertDatabaseMissing('votes',[
            'post_id' => $post->id,
            'user_id' => $user->id,
            'vote' => 1
        ]);

        $this->assertSame(0, $post->score);
    }
}

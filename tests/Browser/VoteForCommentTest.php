<?php

namespace Tests\Browser;

use App\Comment;
use Laravel\Dusk\Browser;
use Tests\{DuskTestCase,TestsHelper};
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteForCommentTest extends DuskTestCase
{
    use DatabaseMigrations, TestsHelper;
    
    function test_a_user_can_vote_for_a_comment()
    {
        $user = $this->defaultUser();

        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser) use ($user, $comment) {
            $browser->loginAs($user)
                ->visit($comment->post->url)
                ->with('.comment', function ($browser) {
                    $browser->pressAndWaitFor('+1');
                    $browser->assertSeeIn('.current-score', 1);
                });
        });

        $comment->refresh();

        $this->assertSame(1, $comment->score);
        // $this->assertDatabaseHas('comments',[
        //     'id' => $comment->id,
        //     'score' => 1
        // ]);

        $this->assertSame(1, $comment->getVoteFrom($user));
    }
}

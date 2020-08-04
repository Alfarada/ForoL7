<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestsHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteForPostTest extends DuskTestCase
{   
    use DatabaseMigrations, TestsHelper;

    public function test_a_user_can_upvote_for_a_post()
    {   
        $user = $this->defaultUser();

        $post = $this->createPost();

        $this->browse(function (Browser $browser) use ($user,$post) {
            $browser->loginAs($user)
                ->visit($post->url)
                ->pressAndWaitFor('+1')
                ->assertSeeIn('#current-score', 1);

        sleep(2);
        
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'score' => 1
        ]);

        $this->assertSame(1, $post->getVoteFrom($user));

        });
    }

    public function test_a_user_can_downvote_for_a_post()
    {   
        $user = $this->defaultUser();

        $post = $this->createPost();

        $this->browse(function (Browser $browser) use ($user,$post) {
            $browser->loginAs($user)
                ->visit($post->url)
                ->pressAndWaitFor('-1')
                ->assertSeeIn('#current-score', -1);

        sleep(2);
        
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'score' => -1
        ]);

        $this->assertSame(-1, $post->getVoteFrom($user));

        });
    }
}

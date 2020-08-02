<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestsHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class VoteForPostTest extends DuskTestCase
{   
    use DatabaseMigrations, TestsHelper;

    public function test_a_user_can_vote_for_a_post()
    {   
        $user = $this->defaultUser();

        $post = $this->createPost();

        $this->browse(function (Browser $browser) use ($user,$post) {
            $browser->loginAs($user)
                ->visit($post->url)
                ->pressAndWaitFor('+1')
                ->assertSeeIn('current-vote', 1);
        });
    }
}

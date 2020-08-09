<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestsHelper;

class LogoutTest extends DuskTestCase
{
    use DatabaseMigrations,TestsHelper;

    function test_a_user_can_logout()
    {   
        $user = $this->defaultUser([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->loginAs($user)
                ->visit('/')
                ->clickLink('Alfredo Yepez')
                ->clickLink('Cerrar sesión')
                ->assertGuest();
        });
    }
}

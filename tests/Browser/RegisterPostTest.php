<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\TestsHelper;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterPostTest extends DuskTestCase
{
    use DatabaseMigrations, TestsHelper;

    public function test_a_user_can_registered()
    {
        $user = $this->defaultUser([
            'email' => 'alfarada@example',
            'username' => 'alfarada',
            'first_name' => 'alfredo',
            'last_name' => 'yepez'
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/register')
                ->assertSee('Register')
                ->type('email',$user->email)
                ->type('username',$user->name)
                ->type('first_name',$user->first_name)
                ->type('last_name',$user->last_name)
                ->press('Regístrate');

            $this->assertDatabaseHas('users', [
                'email' => $user->email,
                'id' => $user->id
            ]);
        });
    }
}

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
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->assertSee('Register')
                ->type('email','lorem@ipsum')
                ->type('username','lorem')
                ->type('first_name','lorem')
                ->type('last_name','ipsum')
                ->press('Regístrate');

            $this->assertDatabaseHas('users', [
                'email' => 'lorem@ipsum',
                'username' => 'lorem'
            ]);
        });
    }
}

<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{  
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $user = factory(User::class)->create([
            'name' => 'Alfredo Yepez',
            'email' => 'hi@ex.net'
        ]);

        $this->actingAs($user, 'api')
            ->get('/api/user')
            ->assertSee('Alfredo Yepez')
            ->assertSee('hi@ex.net');
    }
}

<?php

namespace Tests\Feature;

use App\{User, Token};
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;
use Tests\FeatureTestCase;

class RegistrationTest extends FeatureTestCase
{   
    //Usuario puede crear una cuenta
    public function test_a_user_can_create_an_account()
    {   
        Mail::fake();
        
        $this->visit(route('register'))
            ->type('admin@exmp.com', 'email')
            ->type('alfarada', 'username')
            ->type('Alfredo', 'first_name')
            ->type('Yepez', 'last_name')
            ->press('Regístrate');

        $this->seeInDatabase('users', [
            'email' => 'admin@exmp.com',
            'username' => 'alfarada',
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $user = User::first();

        $this->seeInDatabase('tokens', [
            'user_id' => $user->id
        ]);

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token);

        Mail::assertSent(TokenMail::class, function ($mail) use ($token) {
            return $mail->token->id == $token->id;
        });

        Mail::assertSent(TokenMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });




        //Terminar
        //$this->seeRouteIs('register_confirmation')
        //    ->see('Gracias por registrarte')
        //    ->see('Te enviamos un enlace para que inicies sesión');
    }
}

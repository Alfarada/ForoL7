<?php

namespace Tests\Feature;

use App\Token;
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;
use Tests\FeatureTestCase;

class RequestTokenTest extends FeatureTestCase
{
    //Un invitado puede solicitar un token
    public function test_a_guest_user_can_request_a_token()
    {
        //Having
        Mail::fake();

        $user = $this->defaultUser([
            'email' => 'admin@example.com'
        ]);

        //When
        $this->visitRoute('token')
            ->type('admin@example.com', 'email')
            ->press('Solicitar token');

        $token = Token::where('user_id', $user->id)->first();

        $this->assertNotNull($token, 'Un token no fue generado');

        Mail::assertSent(TokenMail::class, function ($mail) use ($token) {

            return $mail->token->id === $token->id;
        });

        $this->dontSeeIsAuthenticated();

        $this->see('Enviamos a tu email un enlace para que inicies sesión');
    }

    //Un usuario solicita un toquen sin un email
    public function test_a_guest_user_can_request_a_token_without_an_email()
    {
        //Having
        Mail::fake();

        //When
        $this->visitRoute('token')
            ->press('Solicitar token');

        $token = Token::first();

        $this->assertNull($token, 'Un fue generado');

        Mail::assertNotSent(TokenMail::class);

        $this->dontSeeIsAuthenticated();

        $this->seeErrors(['email' => 'El campo correo electrónico es obligatorio']);
    }

    //Un usuario solicita un toquen con email no valido
    public function test_a_guest_user_can_request_a_token_an_invalid_email()
    {
        //When
        $this->visitRoute('token')
            ->type('Alfarada', 'email')
            ->press('Solicitar token');

        $this->seeErrors(['email' => 'Correo electrónico no es un correo válido']);
    }

    //Un usuario solicita un toquen con email válido pero no existe en la bbdd
    public function test_a_guest_user_can_request_a_token_with_a_non_existent_email()
    {
        $this->defaultUser([
            'email' => 'admin@example.com'
        ]);

        //When
        $this->visitRoute('token')
            ->type('next@up.net', 'email')
            ->press('Solicitar token');

        $this->see('Este correo electrónico no existe');
    }
}

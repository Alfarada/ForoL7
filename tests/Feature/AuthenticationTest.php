<?php

namespace Tests\Feature;

use App\Mail\TokenMail;
use App\Token;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tests\FeatureTestCase;
use Illuminate\Support\Str;

class AuthenticationTest extends FeatureTestCase
{
    //Usuario puede iniciar sesión con un token
    public function test_a_user_can_login_with_a_token_url()
    {
        //Having
        $user = $this->defaultUser([]);

        $token = Token::generateFor($user);

        //When
        $this->visit("login/{$token->token}");

        //Then
        $this->seeIsAuthenticated()
            ->seeIsAuthenticatedAs($user);

        $this->dontSeeInDatabase('tokens', [
            'id' => $token->id
        ]);

        $this->seePageIs('/');
    }

    //Usuario no puede iniciar sesión con un token invalido
    public function test_a_user_can_login_with_a_invalid_token_url()
    {
        //Having
        $user = $this->defaultUser([]);

        $token = Token::generateFor($user);

        $invalidToken = Str::random(60);

        //When
        $this->visit("login/{$invalidToken}");

        //Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite un nuevo token');

        $this->seeInDatabase('tokens', [
            'id' => $token->id
        ]);
    }

    //Usuario no puede iniciar sesión con un token 2 veces
    public function test_a_user_cannot_use_the_same_token_twice()
    {
        //Having
        $user = $this->defaultUser([]);

        $token = Token::generateFor($user);

        $token->login();

        Auth::logout();

        //When
        $this->visit("login/{$token->token}");

        //Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite un nuevo token');
    }

    //El token expira despues de los 30 minutos
    public function test_the_token_expires_after_30_minutes()
    {
        //Having
        $user = $this->defaultUser([]);

        $token = Token::generateFor($user);

        Carbon::setTestNow(Carbon::parse('+31 minutes'));

        //When
        $this->visitRoute('login', ['token' => $token->token]);

        //Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite un nuevo token');
    }

    //El token es sensible a minusculas
    public function test_the_token_is_case_sensitive()
    {
        //Having
        $user = $this->defaultUser([]);

        $token = Token::generateFor($user);

        //When
        $this->visitRoute('login', ['token' => strtolower($token->token)]);

        //Then
        $this->dontSeeIsAuthenticated()
            ->seeRouteIs('token')
            ->see('Este enlace ya expiró, por favor solicite un nuevo token');
    }
}

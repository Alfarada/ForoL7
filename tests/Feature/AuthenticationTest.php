<?php

namespace Tests\Feature;

use App\Token;
use Tests\FeatureTestCase;

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
}

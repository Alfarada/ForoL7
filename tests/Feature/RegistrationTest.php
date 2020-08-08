<?php

namespace Tests\Feature;

use App\{User, Token};
use App\Mail\TokenMail;
use Illuminate\Support\Facades\Mail;
use Tests\FeatureTestCase;

class RegistrationTest extends FeatureTestCase
{
    //Usuario puede crear una cuenta
    function test_a_user_can_create_an_account()
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

        $this->see('Gracias por registrarte, Te enviamos un enlace a tu correo para que inicies sesión');
    }

    // Usuario no puede registrarse sin un nombre de usuario
    function test_a_user_cannot_register_without_username()
    {
        // Then
        $this->visit(route('register'))
            ->type('lorem@ipsum.com', 'email')
            ->type('', 'username')
            ->type('alfredo', 'first_name')
            ->type('yepez', 'last_name')
            ->press('Regístrate');

        // When
        $this->dontSeeInDatabase('users', [
            'email' => 'lorem@ipsum.com',
            'username' => '',
            'first_name' => 'alfredo',
            'last_name' => 'yepez'
        ]);

        $this->seeErrors(['username' => 'El campo usuario es obligatorio']);
    }

    // Usuario no puede registrarse sin un nombre de usuario
    function test_a_user_cannot_register_twice_username()
    {
        $this->defaultUser([
            'username' => 'lorem'
        ]);

        // Then
        $this->visit(route('register'))
            ->type('lorem@ipsum.com', 'email')
            ->type('lorem', 'username')
            ->type('alfredo', 'first_name')
            ->type('yepez', 'last_name')
            ->press('Regístrate');

        // When
        $this->dontSeeInDatabase('users', [
            'email' => 'lorem@ipsum.com',
            'username' => 'lorem',
            'first_name' => 'alfredo',
            'last_name' => 'yepez'
        ]);

        $this->seeErrors(['username' => 'El campo usuario ya ha sido registrado']);
    }

    // Usuario no puede registrarse sin un correo electrónico
    function test_a_user_cannot_register_without_email()
    {
        // Then
        $this->visit(route('register'))
            ->type('alfarada', 'username')
            ->type('Alfredo', 'first_name')
            ->type('Yepez', 'last_name')
            ->press('Regístrate');

        // When
        $this->dontSeeInDatabase('users', [
            'username' => 'alfarada',
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $this->seeErrors(['email' => 'El campo correo electrónico es obligatorio']);
    }

    // Usuario no puede registrarse con un correo invalido
    function test_a_user_cannot_register_with_invalid_email()
    {
        // When
        $this->visit(route('register'))
            ->type('correo-no-valido', 'email')
            ->type('alfarada', 'username')
            ->type('Alfredo', 'first_name')
            ->type('Yepez', 'last_name')
            ->press('Regístrate');

        // Then
        $this->dontSeeInDatabase('users', [
            'email' => 'correo-no-valido',
            'username' => 'alfarada',
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $this->seeErrors(['email' => 'Correo electrónico no es un correo válido']);
    }

    // Usuario no puede registrarse dos veces con el mismo correo
    function test_a_user_cannot_register_twice_email()
    {
        // Having
        factory(User::class)->create(['email' => 'lorem@ipsum.com']);

        // When
        $this->visit('register')
            ->type('lorem@ipsum.com', 'email')
            ->type('alfarada', 'username')
            ->type('Alfredo', 'first_name')
            ->type('Yepez', 'last_name')
            ->press('Regístrate');

        // Then
        $this->seeErrors(['email' => 'El correo electrónico ya ha sido registrado']);
    }

    // Usuario no puede registrarse sin el primer nombre 
    function test_a_user_cannot_register_without_first_name()
    {
        // Then
        $this->visit(route('register'))
            ->type('lorem@ipsum.com', 'email')
            ->type('alfarada', 'username')
            ->type('yepez', 'last_name')
            ->press('Regístrate');

        // When
        $this->dontSeeInDatabase('users', [
            'email' => 'lorem@ipsum.com',
            'username' => 'alfarada',
            'last_name' => 'yepez'
        ]);

        $this->seeErrors(['first_name' => 'el campo nombre es obligatorio']);
    }

    // Usuario no puede registrarse sin el segundo nombre 
    function test_a_user_cannot_register_without_last_name()
    {
        // Then
        $this->visit(route('register'))
            ->type('lorem@ipsum.com', 'email')
            ->type('alfarada', 'username')
            ->type('alfredo', 'first_name')
            ->press('Regístrate');

        // When
        $this->dontSeeInDatabase('users', [
            'email' => 'lorem@ipsum.com',
            'username' => 'alfarada',
            'first_name' => 'alfredo'
        ]);

        $this->seeErrors(['last_name' => 'el campo apellido es obligatorio']);
    }
}

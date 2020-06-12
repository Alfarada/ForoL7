<?php

namespace Tests\Feature;

use App\Post;
use Tests\FeatureTestCase;

class CreatePostTest extends FeatureTestCase
{   
    //Usuario crea un post
    function test_a_user_create_post()
    {   
        //Having
        $user = $this->defaultUser([]);
        $title = 'Esta es una pregunta';
        $content = 'Este es el contenido';

        $this->actingAs($user);

        //When
        $this->visit(Route('posts.create'))
            ->type($title, 'title')
            ->type($content, 'content')
            ->press('Publicar');
        
        //Than
        $this->seeInDatabase('posts',[
            'title' => $title,
            'content' => $content,
            'pending' => true,
            'user_id' => $user->id,
        ]);

        $post = Post::first();

        //El autor del post es suscrito automaticamente a su post
        $this->seeInDatabase('subscriptions', [
            'user_id' => $user->id,
            'post_id' => $post->id
        ]);
        
        //Usuario es redirigido al detalle del post despues de crearlo.
        $this->seePageIs($post->url);
    }

    //Para crear un post el usuario necesita iniciar sesión
    function test_creating_a_post_requires_authentication()
    {   
        $this->visit(Route('posts.create'))
            ->seePageIs(route('token'));
    }

    //Creando post para validacion
    function test_create_post_for_validation()
    {
        $user = $this->defaultUser([]);

        $this->actingAs($user)
            ->visit(route('posts.create'))
            ->press('Publicar')
            ->seePageIs(route('posts.create'))
            ->seeErrors([
                'title' => 'El campo título es obligatorio',
                'content' => 'El campo contenido es obligatorio'
            ]);
    }
}

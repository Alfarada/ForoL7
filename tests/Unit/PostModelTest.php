<?php

namespace Tests\Unit;

use App\Post;
use PHPUnit\Framework\TestCase;

class PostModelTest extends TestCase
{   
    //Agregar un titulo genera un slug
    function test_adding_a_title_generates_a_slug()
    {
        $post = new Post([
            'title'=> 'Como instalar Laravel'
        ]);

        $this->assertSame('como-instalar-laravel', $post->slug);
    }

    //Cambiar un titulo cambia el slug
    function test_editing_the_title_changes_the_slug()
    {
        $post = new Post([
            'title' => 'Como instalar laravel '
        ]);

        $post->title = 'Como instalar laravel 5.1 LTS';

        $this->assertSame('como-instalar-laravel-51-lts', $post->slug);
    }
}

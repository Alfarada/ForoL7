<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class SlugPostTest extends FeatureTestCase
{
    //Un slug es generado y guardado en la base de datos.
    function test_a_slug_is_generated_and_saved_to_the_databse()
    {
        $post = $this->createPost([
            'title'=> 'Como instalar Laravel',
        ]);

        //dd($post->toArray());

        $this->seeInDatabase('posts',[
            'slug' => 'como-instalar-laravel'
        ]);
        
        $this->assertSame('como-instalar-laravel', $post->slug);
    }
}

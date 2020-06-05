<?php

namespace Tests\Feature;

use App\Post;
use Tests\FeatureTestCase;

class PostSlugTest extends FeatureTestCase
{
    //Un slug es generado y guardado en la base de datos.
    function test_a_slug_is_generated_and_saved_to_the_databse()
    {
        $user = $this->getdefaultUser();

        $post = factory(Post::class)->make([
            'title'=> 'Como instalar Laravel',
        ]);

        $user->posts()->save($post);

        $this->seeInDatabase('posts',[
            'slug' => 'como-instalar-laravel'
        ]);
        
        $this->assertSame('como-instalar-laravel', $post->slug);
    }
}

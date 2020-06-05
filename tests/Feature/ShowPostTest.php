<?php

namespace Tests\Feature;

use App\Post;
use Tests\FeatureTestCase;

class ShowPostTest extends FeatureTestCase
{   
    //Usuario puede ver detalles del post
    function test_a_user_can_see_the_post_details()
    {   
        //Having
        $user = $this->setdefaultUser([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $post = factory(Post::class)->make([
            'title' => 'Este es el título del post',
            'content' => 'Este es el contenido del post'
        ]);

        $user->posts()->save($post);

        //When
        //dd(route('posts.show', $post));

        $this->visitRoute('posts.show', $post)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($post->first_name);

    }
}

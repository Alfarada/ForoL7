<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class ShowPostTest extends FeatureTestCase
{
    //Usuario puede ver detalles del post
    function test_a_user_can_see_the_post_details()
    {
        //Having
        $user = $this->defaultUser([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez'
        ]);

        $post = $this->createPost([
            'title' => 'Este es el título del post',
            'content' => 'Este es el contenido del post',
            'user_id' => $user->id
        ]);

        //When
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($post->first_name);
    }

    //Comprobar que las url obsoletas redirigen a las url nuevas
    function test_old_url_are_redirected()
    {
        //Having
        $post = $this->createPost([
            'title' => 'Old title'
        ]);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }
}

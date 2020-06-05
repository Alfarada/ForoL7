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
        $this->visit($post->url)
            ->seeInElement('h1', $post->title)
            ->see($post->content)
            ->see($post->first_name);
    }

    function test_old_url_are_redirected()
    {
        //Having
        $user = $this->getdefaultUser();

        $post = factory(Post::class)->make([
            'title' => 'Old title'
        ]);

        $user->posts()->save($post);

        $url = $post->url;

        $post->update(['title' => 'New title']);

        $this->visit($url)
            ->seePageIs($post->url);
    }
}

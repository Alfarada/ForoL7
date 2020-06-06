<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class PostListTest extends FeatureTestCase
{   
    //Usuario puede ver el listado de post e ir a los detalles
    public function test_a_user_can_see_posts_list_and_go_to_the_details()
    {   
        $post = $this->createPost([
            'title' => 'Debo usar laravel 7 o laravel 6 LTS'
        ]);

        $this->visitRoute('posts.index')
            ->seeInElement('h1', 'Posts')
            ->see($post->title)
            ->click($post->title)
            ->seePageIs($post->url);
    }
}

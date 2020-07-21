<?php

namespace Tests\Feature;

use App\Category;
use App\Post;
use Carbon\Carbon;
use Tests\FeatureTestCase;

class PostListTest extends FeatureTestCase
{   
    //Usuario puede ver el listado de post e ir a los detalles
    function test_a_user_can_see_posts_list_and_go_to_the_details()
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

    //Usuario puede ver el listado de posts y ver los detalles del mismo
    function test_a_user_can_see_posts_filtered_by_category()
    {
        
        $laravel = factory(Category::class)->create([
            'name' => 'Laravel', 'slug' => 'laravel'
        ]);

        $vue = factory(Category::class)->create([
            'name' => 'Vue.js', 'slug' => 'vue-js'
        ]);

        $laravelPost = factory(Post::class)->create([
            'title' => 'Posts de laravel',
            'category_id' => $laravel->id
        ]);

        $vuePost = factory(Post::class)->create([
            'title' => 'Posts de Vue.js',
            'category_id' => $vue->id
        ]);

        $this->visit('/')
            ->see($laravelPost->title)
            ->see($vuePost->title)
            ->within('.categories', function () {
                $this->click('Laravel');
            })
            ->seeInElement('h1', 'Posts de laravel')
            ->see($laravelPost->title)
            ->dontSee($vuePost->title);
    }

    //Paginacion de post
    function test_the_posts_are_paginated()
    {   
        //Having
        $first = factory(Post::class)->create([
            'title' => 'Post antiguo',
            'created_at' => Carbon::now()->subDays(2)
        ]);

        factory(Post::class)->times(15)->create([
            'created_at' => Carbon::now()->subDay()
        ]);

        $last = factory(Post::class)->create([
            'title' => 'Post reciente',
            'created_at' => Carbon::now()
        ]);

        $this->visit('/')
        ->see($last->title)
        ->dontSee($first->title)
        ->click('2')
        ->see($first->title)
        ->dontSee($last->title);
    }
}

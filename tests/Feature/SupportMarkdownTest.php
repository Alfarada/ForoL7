<?php

namespace Tests\Feature;

use Tests\FeatureTestCase;

class SupportMarkdownTest extends FeatureTestCase
{
    function test_the_post_content_support_markdown()
    {
        $importantText = 'Un texto muy importante';

        $post = $this->createPost([
            'content' => "La primera  parte del texto. **$importantText** . La ultima parte del texto"
        ]);

        $this->visit($post->url)
            ->seeInElement('strong', $importantText);
    }

    function test_xss_attack()
    {
        $xssAtack = "<script>alert('Malicius JS!')</script>";

        $post = $this->createPost([
            'content' => "$xssAtack. texto normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAtack)
            ->seeText('texto normal')
            ->seeText($xssAtack);
    }

    function test_xss_attack_with_html()
    {
        $xssAtack = "<img src='img.jpg'>";

        $post = $this->createPost([
            'content' => "$xssAtack. texto normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAtack);
    }

    function test_the_code_in_the_post_is_escaped()
    {
        $xssAtack = "<script>alert('Sharing code')</script>";

        $post = $this->createPost([
            'content' => "`$xssAtack`. texto normal"
        ]);

        $this->visit($post->url)
            ->dontSee($xssAtack)
            ->seeText('texto normal')
            ->seeText($xssAtack);
    }
}

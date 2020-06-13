<?php

namespace Tests\Feature;

use App\{User, Token};
use App\Mail\TokenMail;
use Tests\FeatureTestCase;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\DomCrawler\Crawler;

class TokenMailTest extends FeatureTestCase
{
    public function tests_sends_a_link_with_the_token()
    {
        $user = new User([
            'first_name' => 'Alfredo',
            'last_name' => 'Yepez',
            'email' => 'alfarada@hi.net'
        ]);

        $token = new Token([ 
            'token' => 'this-is-a-token',
            'user' => $user
        ]);

        $this->open( new TokenMail($token))
            ->seeLink($token->url, $token->url);
    }

    protected function open(Mailable $mailable)
    {
        $transport = Mail::getSwiftMailer()->getTransport();

        $transport->flush();

        Mail::send($mailable); 

        $message = $transport->messages()->first();

        //dd(get_class($message)); dd($message->getBody());
        
        $this->crawler = new Crawler($message->getBody());

        return $this;
    }
}

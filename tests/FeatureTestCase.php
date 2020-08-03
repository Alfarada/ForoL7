<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeatureTestCase extends \Laravel\BrowserKitTesting\TestCase
{   
    use  CreatesApplication, TestsHelper, RefreshDatabase;

    public $baseUrl = 'http://foro7.test';

    public function seeErrors(array $fields)
    {
        foreach ($fields as $name => $errors) {
            foreach ((array) $errors as $message) {
                $this->seeInElement(
                    "#field_{$name} .invalid-feedback",
                    $message
                );
            }
        }
    }
}

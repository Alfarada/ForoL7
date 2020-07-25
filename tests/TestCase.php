<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
//use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use DatabaseTransactions;
    // use DatabaseMigrations;
    //use RefreshDatabase;

    public $baseUrl = 'http://foro7.test';
   
}


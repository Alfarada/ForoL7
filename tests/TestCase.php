<?php

namespace Tests;

//use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, TestsHelper, RefreshDatabase;
   
}


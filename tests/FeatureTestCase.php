<?php

namespace Tests;

class FeatureTestCase extends TestCase
{   
    public function seeErrors(array $fields)
    {
        foreach($fields as $name => $errors){
            foreach ((array) $errors as $message) {
                $this->seeInElement(
                    "#field_{$name} .invalid-feedback", $message
                );
            }
        }       
    }
}
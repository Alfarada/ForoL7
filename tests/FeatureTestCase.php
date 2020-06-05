<?php

namespace Tests;

use App\User;

class FeatureTestCase extends TestCase
{   
    //Usuario por defecto
    public function getdefaultUser()
    {
        return $this->getdefaultUser = factory(User::class)->create();
    }

    //Usuario personalizado
    public function setdefaultUser(array $data)
    {
        return $this->setdefaultUser = factory(User::class)->create($data);
    }

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
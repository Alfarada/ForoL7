<?php

namespace Tests;

use App\Post;
use App\User;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    public function defaultUser( array $attributes)
    {
        return $this->defaultUser = factory(User::class)->create($attributes);
    }

    public function createPost( array $attributes = [])
    {
        return factory(Post::class)->create($attributes);
    }
}

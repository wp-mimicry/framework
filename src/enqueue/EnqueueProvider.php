<?php

namespace Mimicry\Hooks;

use Mimicry\Enqueue\Enqueue;
use Mimicry\Foundation\Provider;

final class ServiceRegisterProvider extends Provider {

    public function register()
    {
        $this->app->singleton('Mimicry\Enqueue\Enqueue', function(){
            return Enqueue::instance();
        });
    }

}
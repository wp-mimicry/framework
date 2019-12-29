<?php

namespace Mimicry\Foundation;

use Mimicry\Foundation\App;

abstract class Provider {

    protected $app = null;


    public function __construct(App $app)
    {
        $this->app = $app;
    }

}
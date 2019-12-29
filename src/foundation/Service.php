<?php
namespace Mimicry\Foundation;

use Mimicry\Foundation\App;

abstract class Service {

    protected $app = null;


    public function __construct(App $app)
    {
        $this->app = $app;
    }

}
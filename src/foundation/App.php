<?php

namespace Mimicry\Foundation;

use \Illuminate\Container\Container;

class App extends Container {

    protected $version = '1.0.0';

    public $nametotest = "MIMICRY";


    public function __construct()
    {
        $this->registerBaseBindings();
    }


    public function version()
    {
        return $this->version;
    }


    protected function registerBaseBindings()
    {
        static::setInstance($this);

        $this->instance('app', $this);

        $this->instance(\Mimicry\Foundation\App::class, $this);

        $this->instance(\Illuminate\Container\Container::class, $this);

        $this->singleton(\Mimicry\Foundation\Kernel::class, \Mimicry\Foundation\Kernel::class);
    }

}

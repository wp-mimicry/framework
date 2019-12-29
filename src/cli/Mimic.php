<?php
namespace Mimicry\Cli;

use Illuminate\Contracts\Container\BindingResolutionException;
use \Mimicry\Foundation\App;

class Mimic {

    private $app = null;


    public function __construct()
    {
        $this->app = new App();

        $this->initializeKernel();
    }


    private function initializeKernel(): void
    {
        try {
            $kernel = $this->app->make(\Mimicry\Cli\Kernel::class);
            $kernel->init();
        } catch (BindingResolutionException $e) {
            die($e->getMessage());
        }
    }

}
<?php

namespace Mimicry\Cli;

use Mimicry\Cli\Application;
use Mimicry\Foundation\App;

class Kernel {

    protected $app = null;

    protected $cli = null;

    protected $commands = [
        'TestCommand' => \Mimicry\Cli\Commands\TestCommand::class
    ];


    public function __construct(App $app)
    {
        $this->app = $app;

        $this->cli = new Application();
    }


    public function init()
    {
        $this->addCommands();

        try {
            $this->cli->run();
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }


    private function addCommands()
    {
        foreach ($this->commands as $command) {
            $this->cli->add($this->app->make($command));
        }
    }

}
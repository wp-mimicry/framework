<?php

namespace Mimicry\Hooks;

use Mimicry\Foundation\App;
use Mimicry\Foundation\Service;

class HooksHandler {

    protected $app = null;

    protected $baseHook = ['hook' => '', 'callback' => '', 'priority' => 10, 'arguments' => 1];


    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function registerHooks(Service $service, Array $hooks): void
    {
        foreach ($hooks as $hook) {
            $this->registerHook($service, $hook);
        }
    }


    public function registerHook(Service $service, Array $hook): void
    {
        $hook = $this->validateHooksArray($hook);
        $this->add_hook($hook['hook'], $service, $hook['callback'], $hook['priority'], $hook['arguments']);
    }


    public function add_hook(string $hook_name, $instance, string $method, int $priority = 10, int $accepted_args = 1)
    {
        $app = $this->app;

        \add_action(
            $hook_name,
            function () use ($app, $instance, $method) {
                return $app->call(array($instance, $method), func_get_args());
            },
            $priority,
            $accepted_args
        );
    }


    public function validateHooksArray($hook)
    {
        $filteredHook['hook'] = isset($hook['hook']) ? $hook['hook'] : $hook[0];
        $filteredHook['callback'] = isset($hook['callback']) ? $hook['callback'] : $hook[1];
        $filteredHook['priority'] = isset($hook['priority']) ? $hook['priority'] : (isset($hook[2]) ? $hook[2] : 10);
        $filteredHook['arguments'] = isset($hook['arguments']) ? $hook['arguments'] : (isset($hook[3]) ? $hook[3] : 1);
        return $filteredHook;
    }

}
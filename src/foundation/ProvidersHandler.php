<?php
namespace Mimicry\Foundation;

use Exception;

class ProvidersHandler {

    private $app = null;

    private $providers = [];


    public function __construct(App $app)
    {
        $this->app = $app;;
    }


    public function init(array $providers = []): void
    {
        $this->makeProviders($providers);

        $this->registerProviders();

        $this->bootProviders();

        $this->registerShutdownHook();
    }


    private function makeProviders(Array $providers): void
    {
        foreach ($providers as $name => $abstract) {
            try {
                $concrete = $this->app->make($abstract);
                $this->app->instance($abstract, $concrete);
            } catch (Exception $e) {
                \wp_die($e->getMessage());
            }

            $this->providers[] = $concrete;
        }
    }


    private function registerProviders(): void
    {
        $this->callMethodOnProviders('register');
    }


    private function bootProviders(): void
    {
        $this->callMethodOnProviders('boot');
    }


    private function registerShutdownHook(): void
    {
        if (\count($this->providers) > 0) {
            \add_action('shutdown', array($this, 'shutdown'));
        }
    }


    public function shutdown(): void
    {
        $this->callMethodOnProviders('shutdown');
    }


    private function callMethodOnProviders(string $method): void
    {
        foreach ($this->providers as $provider) {
            if (\method_exists($provider, $method)) {
                $this->app->call(array($provider, $method));
            }
        }
    }

}
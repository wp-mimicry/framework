<?php
/**
 * ProvidersHandler
 *
 * Run the provider classes.
 *
 * @package             Mimicry
 * @subpackage          Mimicry\Foundation;
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @copyright           2020 Stephan Nijman
 * @license             GPL-2.0-or-later
 * @version             1.0.0
 */

namespace Mimicry\Foundation;

use Exception;

class ProvidersHandler {

    /**
     * app.
     *
     * @var App Service container.
     *
     * @access private
     */
    private $app = null;

    /**
     * $providers.
     *
     * @var array The providers.
     *
     * @access private
     */
    private $providers = [];


    /**
     * __construct.
     *
     * Initialize the class.
     *
     * @param App $app Service container.
     * @access public
     */
    public function __construct(App $app)
    {
        $this->app = $app;;
    }


    /**
     * init.
     *
     * Initialize the handler.
     *
     * @access public
     * @return void
     */
    public function init(array $providers = []): void
    {
        $this->makeProviders($providers);

        $this->registerProviders();

        $this->bootProviders();

        $this->registerShutdownHook();
    }


    /**
     * makeProviders.
     *
     * Run through the providers and mace concrete instances.
     *
     * @param array $providers list of providers
     * @access public
     * @return void
     */
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


    /**
     * registerProviders.
     *
     * Call the register method on the providers.
     *
     * @access private
     * @return void
     */
    private function registerProviders(): void
    {
        $this->callMethodOnProviders('register');
    }


    /**
     * bootProviders.
     *
     * Call the boot method on the providers.
     *
     * @access private
     * @return void
     */
    private function bootProviders(): void
    {
        $this->callMethodOnProviders('boot');
    }


    /**
     * registerShutdownHook.
     *
     * Register with the shutdown WordPress hook.
     *
     * @access private
     * @return void
     */
    private function registerShutdownHook(): void
    {
        if (\count($this->providers) > 0) {
            \add_action('shutdown', array($this, 'shutdownProviders'));
        }
    }


    /**
     * shutdown.
     *
     * Call the shutdown method on the providers.
     *
     * @access public
     * @return void
     */
    public function shutdownProviders(): void
    {
        $this->callMethodOnProviders('shutdown');
    }


    /**
     * callMethodOnProviders.
     *
     * Call the provided method on all providers.
     *
     * @param string $method method to call.
     * @access private
     * @return void
     */
    private function callMethodOnProviders(string $method): void
    {
        foreach ($this->providers as $provider) {
            if (\method_exists($provider, $method)) {
                $this->app->call(array($provider, $method));
            }
        }
    }

}
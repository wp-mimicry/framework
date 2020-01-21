<?php
namespace Mimicry\Foundation;

use Exception;

/**
 * ProvidersHandler
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
class ProvidersHandler {

    /**
     * @var Container $app Service container instance.
     * @access private
     */
    private $app = null;

    /**
     * @var array $providers An array of provider classes.
     * @access private
     */
    private $providers;


    /**
     * __construct.
     *
     * Initialize the class.
     *
     * @param App $app Service container.
     *
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
     * @param array $providers An array of provider classes.
     *
     * @access public
     * @return void
     */
    public function init(array $providers = [])
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
     *
     * @access public
     */
    private function makeProviders(Array $providers)
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
    private function registerProviders()
    {
        $this->callMethodOnProviders('register');
    }


    /**
     * bootProviders.
     *
     * Call the boot method on the providers.
     *
     * @access private
     */
    private function bootProviders()
    {
        $this->callMethodOnProviders('boot');
    }


    /**
     * registerShutdownHook.
     *
     * Register with the shutdown WordPress hook.
     *
     * @access private
     */
    private function registerShutdownHook()
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
     */
    public function shutdownProviders()
    {
        $this->callMethodOnProviders('shutdown');
    }


    /**
     * callMethodOnProviders.
     *
     * Call the provided method on all providers.
     *
     * @param string $method method to call.
     *
     * @access private
     */
    private function callMethodOnProviders(string $method)
    {
        foreach ($this->providers as $provider) {
            if (\method_exists($provider, $method)) {
                $this->app->call(array($provider, $method));
            }
        }
    }

}
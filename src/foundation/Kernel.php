<?php
namespace Mimicry\Foundation;

use \Illuminate\Contracts\Container\BindingResolutionException;
use \Illuminate\Config\Repository;

/**
 * Kernel
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class Kernel {

    /**
     * @var Container $app Service container instance.
     * @access private
     */
    protected $app = null;

    /**
     * @var array $coreProviders The core Provider classes to load.
     * @access private
     */
    protected $coreProviders = [
        'tagsProvider' => \Mimicry\Tags\tagsProvider::class,
        'ServiceOptionalProvider' => \Mimicry\Services\ServiceOptionalProvider::class,
        'ServiceInitializerProvider' => \Mimicry\Services\ServiceInitializerProvider::class,
        'ServiceRegisterProvider' => \Mimicry\Hooks\ServiceRegisterProvider::class,
    ];


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
        $this->app = $app;
    }


    /**
     * init.
     *
     * Initialize this Kernel.
     *
     * @access public
     */
    public function init()
    {
        $this->loadCoreConfig();

        $this->app->call(array($this, 'handleProviders'));

        $this->app->call(array($this, 'handleServices'));
    }


    /**
     * loadCoreConfig.
     *
     * Load the main configuration file.
     *
     * @access private
     */
    private function loadCoreConfig()
    {
        try {
            ($this->app->make(ConfigProvider::class))->register();
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }


    /**
     * handleProviders.
     *
     * Merge the core providers with public providers.
     * and pass them to the ProvidersHandler.
     *
     * @param Repository $config
     *
     * @access public
     */
    public function handleProviders(Repository $config)
    {
        $providers = \array_merge($this->coreProviders, $config->get('providers'));

        try {
            ($this->app->make(ProvidersHandler::class))->init($providers);;
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }


    /**
     * handleServices.
     *
     * Get services array from the app config,
     * adn pass them to the ServicesHandler.
     *
     * @param Repository $config
     *
     * @access public
     */
    public function handleServices(Repository $config)
    {
        $services = $config->get('services');

        try {
            ($this->app->make(ServicesHandler::class))->init($services);
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }

}
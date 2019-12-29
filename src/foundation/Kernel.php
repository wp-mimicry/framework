<?php
/**
 * Kernel
 *
 * Run Providers and Services.
 *
 * @package             Mimicry
 * @subpackage          Mimicry\Foundation;
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @copyright           2020 Stephan Nijman
 * @license             GPL-2.0-or-later
 * @version             1.0.0
 */

namespace Mimicry\Foundation;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Config\Repository;

/**
 * Class Kernel
 *
 * @package Mimicry\Foundation
 */
final class Kernel {

    /**
     * app.
     *
     * @var Container Service container.
     *
     * @access private
     */
    protected $app = null;


    /**
     * coreProviders.
     *
     * @var Array Core providers.
     *
     * @access protected
     */
    protected $coreProviders = [
        'tagsProvider' => \Mimicry\Tags\tagsProvider::class,
        'ServiceOptionalProvider' => \Mimicry\Services\ServiceOptionalProvider::class,
        'ServiceInitializerProvider' => \Mimicry\Services\ServiceInitializerProvider::class,
        'ServiceRegisterProvider' => \Mimicry\Hooks\ServiceRegisterProvider::class
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
        $this->app->instance(\Mimicry\Foundation\Kernel::class, $this);
    }


    /**
     * init.
     *
     * Initialize the Kernel.
     *
     * @access public
     * @return void
     */
    public function init(): void
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
     * @return void
     */
    private function loadCoreConfig(): void
    {
        try {
            $ConfigHandler = $this->app->make('Mimicry\Foundation\ConfigProvider');
            $ConfigHandler->register();
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }


    /**
     * handleProviders.
     *
     * Load the providers into the provider handler.
     *
     * @param Repository $config
     * @access public
     * @return void
     */
    public function handleProviders(Repository $config): void
    {
        $providers = array_merge($this->coreProviders, $config->get('providers'));

        try {
            $ProvidersHandler = $this->app->make('Mimicry\Foundation\ProvidersHandler');
            $ProvidersHandler->init($providers);
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }


    /**
     * handleServices.
     *
     * Load the services into the service handler.
     *
     * @param Repository $config
     * @access public
     * @return void
     */
    public function handleServices(Repository $config): void
    {
        $services = $config->get('services');

        try {
            $serviceContainer = $this->app->make('Mimicry\Foundation\ServicesHandler');
            $serviceContainer->init($services);
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }

}
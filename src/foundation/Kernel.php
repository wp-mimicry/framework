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

    private $app = null;

    private $coreProviders = [
        'tagsProvider' => \Mimicry\Tags\tagsProvider::class,
        'ServiceOptionalProvider' => \Mimicry\Services\ServiceOptionalProvider::class,
        'ServiceInitializerProvider' => \Mimicry\Services\ServiceInitializerProvider::class,
        'RegisterProvider' => \Mimicry\Hooks\RegisterProvider::class
    ];


    /**
     * Kernel constructor.
     *
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->app->instance(\Mimicry\Foundation\Kernel::class, $this);
    }


    /**
     *
     */
    public function init(): void
    {
        $this->loadCoreConfig();

        $this->app->call(array($this, 'handleProviders'));

        $this->app->call(array($this, 'handleServices'));
    }


    /**
     *
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
     * @param Repository $config
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
     * @param Repository $config
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
<?php
namespace Mimicry\Hooks;

use Mimicry\Foundation\Provider;

/**
 * ServiceRegisterProvider
 *
 * @package             Mimicry\Hooks
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ServiceRegisterProvider extends Provider {

    /**
     * register.
     *
     * Register items into then Service container.
     *
     * @access public
     */
    public function register()
    {
        $this->app->singleton('Mimicry\Hooks\HooksHandler', \Mimicry\Hooks\HooksHandler::class);
    }


    /**
     * boot.
     *
     * Get hooks from the services and register them with the HooksHandler.
     *
     * @param HooksHandler $handler Hooks handleing class.
     * @access public
     */
    public function boot(HooksHandler $handler)
    {
        \add_action('mimicry_handle_service', function ($service) use ($handler) {
            if (\method_exists($service, 'register')) {
                $hooks = $this->app->call(array($service, 'register'));
                $handler->registerHooks($service, $hooks);
            }
        });
    }

}
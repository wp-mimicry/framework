<?php
namespace Mimicry\Services;

use Mimicry\Foundation\Provider;

/**
 * ServiceInitializerProvider
 *
 * @package             Mimicry\Services
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ServiceInitializerProvider extends Provider {

    /**
     * boot.
     *
     * Call the init method if a service provides one.
     *
     * @access public
     */
    public function boot()
    {
        \add_action('mimicry_handle_service', function ($service) {
            if (\method_exists($service, 'init')) {
                $this->app->call(array($service, 'init'));
            }
        });
    }

}
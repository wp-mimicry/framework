<?php
namespace Mimicry\Foundation;

use Exception;
use Mimicry\Foundation\Service;

/**
 * Provider
 *
 * @package             Mimicry\Foundation
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ServicesHandler {

    /**
     * @var Container $app Service container instance.
     * @access private
     */
    private $app = null;

    /**
     * @var array $services An array of services.
     * @access private
     */
    private $services = [];


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
        $this->app = $app;
    }


    /**
     * init.
     *
     * Make instances of the service classes.
     *
     * @param array $services List of services.
     *
     * @access public
     */
    public function init(array $services)
    {
        $services = $this->filterServices($services);

        foreach ($services as $name => $abstract) {
            try {
                $concrete = $this->app->make($abstract);
                $this->app->instance($abstract, $concrete);
            } catch (Exception $e) {
                \wp_die($e->getMessage());
            }

            $this->hookService($concrete);

            $this->services[] = $concrete;
        }
    }


    /**
     * filterServices.
     *
     * Apply the mimicry_service_array filter on the services array.
     *
     * @param array $services List of services.
     *
     * @access private
     * @return array
     */
    private function filterServices(array $services): array
    {
        return \apply_filters('mimicry_service_array', $services);
    }


    /**
     * hookService.
     *
     * Apply the mimicry_handle_service action on individual services.
     *
     * @param Service $service service instance.
     *
     * @access private
     */
    private function hookService(Service $service)
    {
        \do_action('mimicry_handle_service', $service);
    }

}
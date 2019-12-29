<?php
namespace Mimicry\Foundation;

use Exception;
use Mimicry\Foundation\Service;

class ServicesHandler {

    private $app = null;

    private $services = [];


    public function __construct(App $app)
    {
        $this->app = $app;
    }


    public function init(array $services): void
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


    private function filterServices(array $services): array
    {
        return \apply_filters('mimicry_service_array', $services);
    }


    private function hookService(Service $service)
    {
        \do_action('mimicry_handle_service', $service);
    }

}
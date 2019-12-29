<?php

namespace Mimicry\Services;

class ServiceOptionalProvider {

    protected $neededServices = [];


    public function boot()
    {
        \add_filter('mimicry_service_array', function ($services) {
            foreach ($services as $service) {
                if ($this->serviceNneeded($service)) {
                    $this->neededServices[] = $service;
                }
            }

            return $this->neededServices;
        });
    }


    private function serviceNneeded($service)
    {
        return (\method_exists($service, 'optional') and !$service::optional()) ? false : true;
    }

}
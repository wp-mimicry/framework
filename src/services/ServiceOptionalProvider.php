<?php
namespace Mimicry\Services;

use Mimicry\Foundation\Service;

/**
 * ServiceOptionalProvider
 *
 * @package             Mimicry\Services
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ServiceOptionalProvider {

    protected $neededServices = [];


    /**
     * register.
     *
     * Filter the needed services.
     *
     * @access public
     */
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


    /**
     * serviceNneeded.
     *
     * Determine if a service is needed for the current requesst.
     *
     * @param string $service A service instance.
     * @access public
     */
    private function serviceNneeded(string $service)
    {
        return (\method_exists($service, 'optional') and !$service::optional()) ? false : true;
    }

}
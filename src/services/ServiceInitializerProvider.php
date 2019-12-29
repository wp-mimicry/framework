<?php

namespace Mimicry\Services;

use Mimicry\Foundation\Provider;

final class ServiceInitializerProvider extends Provider {

    public function boot()
    {
        add_action('mimicry_handle_service', function ($service) {
            if (\method_exists($service, 'init')) {
                $this->app->call(array($service, 'init'));
            }
        });
    }

}
<?php

namespace Mimicry\Hooks;

use Mimicry\Foundation\Provider;

final class RegisterProvider extends Provider {

    public function register()
    {
        $this->app->singleton('Mimicry\Hooks\HooksHandler', \Mimicry\Hooks\HooksHandler::class);
    }


    public function boot(HooksHandler $handler)
    {
        add_action('mimicry_handle_service', function ($service) use ($handler) {
            if (\method_exists($service, 'register')) {
                $hooks = $this->app->call(array($service, 'register'));
                $handler->registerHooks($service, $hooks);
            }
        });
    }

}
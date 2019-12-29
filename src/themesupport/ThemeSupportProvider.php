<?php

namespace Mimicry\Themesupport;

use Illuminate\Contracts\Container\BindingResolutionException;
use Mimicry\Foundation\Provider;

class ThemeSupportProvider extends Provider {

    public function boot()
    {
        try {
            $ThemeSupportHandler = $this->app->make('Mimicry\Themesupport\ThemeSupportHandler');
            $ThemeSupportHandler->init();
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }

}
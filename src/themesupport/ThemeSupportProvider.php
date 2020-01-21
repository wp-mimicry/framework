<?php

namespace Mimicry\Themesupport;

use Illuminate\Contracts\Container\BindingResolutionException;
use Mimicry\Foundation\Provider;

class ThemeSupportProvider extends Provider {

    public function boot()
    {
        try {
            ($this->app->make('Mimicry\Themesupport\ThemeSupportHandler'))->init();
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }

}
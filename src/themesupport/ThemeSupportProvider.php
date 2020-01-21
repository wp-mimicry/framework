<?php
namespace Mimicry\Themesupport;

use Illuminate\Contracts\Container\BindingResolutionException;
use Mimicry\Foundation\Provider;

/**
 * ServiceRegisterProvider
 *
 * @package             Mimicry\Themesupport
 * @author              Stephan Nijman <vanaf1979@gmail.com>
 * @license             GPL-2.0-or-later
 */
final class ThemeSupportProvider extends Provider {

    /**
     * boot.
     *
     * Create a ThemeSupportHandler instance and initialize it.
     *
     * @access public
     */
    public function boot()
    {
        try {
            ($this->app->make('Mimicry\Themesupport\ThemeSupportHandler'))->init();
        } catch (BindingResolutionException $e) {
            \wp_die($e->getMessage());
        }
    }

}
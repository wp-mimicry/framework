<?php

use Mimicry\Foundation\App;

/**
 * MimicryApp.
 *
 * Return a instance of the App container.
 *
 * @return void
 */
if (!function_exists('App')) {
    function App(): App
    {
        return App::getInstance();
    }
}





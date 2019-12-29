<?php
/**
 * dd.
 *
 * Dump variable and die.
 *
 * @return void
 */
if (!function_exists('dd')) {
    function dd()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
        die();
    }
}

/**
 * d.
 *
 * Dump variable.
 *
 * @return void
 */
if (!function_exists('d')) {
    function d()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
    }
}
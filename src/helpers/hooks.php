<?php
if (!function_exists('add_hook')) {
    function add_hook(...$args)
    {
        $hook = ['hook' => $args[0], 'callback' => $args[2], 'priority' => $args[3], 'arguments' => $args[4]];
        app()->get('\Mimicry\Hooks\HooksHandler')->registerHook($args[1], $hook);
    }
}
<?php
/**
 * theme_path.
 *
 * Return path to current theme with trailing slash.
 * If $file is given it is appended.
 *
 * @param string $file
 *
 * @return string
 */
if (!function_exists('theme_path')) {
    function theme_path(string $file = ''): string
    {
        return \get_template_directory() . DIRECTORY_SEPARATOR . $file;
    }
}

/**
 * parent_theme_path.
 *
 * Return path to parent or current theme if no parent exists.
 * If $file is given it is appended.
 *
 * @param string $file
 *
 * @return string
 */
if (!function_exists('parent_theme_path')) {
    function parent_theme_path(string $file = ''): string
    {
        return \get_stylesheet_directory() . DIRECTORY_SEPARATOR . $file;
    }
}

/**
 * theme_uri.
 *
 * Return uri to current theme.
 * If $file is given it is appended.
 *
 * @param string $file
 *
 * @return string
 */
if (!function_exists('theme_uri')) {
    function theme_uri(string $file = ''): string
    {
        return \get_stylesheet_directory_uri() . '/' . ltrim( $file , '/' );
    }
}

/**
 * parent_theme_uri.
 *
 * Return url to parent theme, or current theme if no parent exists.
 * If $file is given it is appended.
 *
 * @param string $file
 *
 * @return string
 */
if (!function_exists('parent_theme_uri')) {
    function parent_theme_uri(string $file = ''): string
    {
        return \get_template_directory_uri() . '/' . ltrim( $file , '/' );
    }
}